<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index($categoryId = null, $categorySlug = null)
    {
        $model = new ProductModel();
        $q     = $this->request->getGet('q');
        $price = $this->request->getGet('price');
        $stock = $this->request->getGet('stock');
        $db    = \Config\Database::connect();
        $title = 'All Products - Jacquelle';

        $seg = strtok((string) uri_string(), '/');
        $types = ['featured-products' => 'featured', 'discounts' => 'discount', 'bundles' => 'bundle'];
        $type = $types[$seg] ?? 'all';
        $heading = 'All Products';
        if ($type === 'featured') {
            $title = 'Produk Unggulan - Jacquelle';
            $heading = 'Produk Unggulan';
        } elseif ($type === 'discount') {
            $title = 'Diskon - Jacquelle';
            $heading = 'Diskon';
        } elseif ($type === 'bundle') {
            $title = 'Produk Bundle - Jacquelle';
            $heading = 'Produk Bundle';
        }

        $priceRanges = [
            'below-72000'           => [0, 71999],
            '72000-140000'          => [72000, 140000],
            '140000-210000'         => [140000, 210000],
            '210000-999999999'      => [210000, PHP_INT_MAX],
        ];

        if ($categoryId) {
            $ids = $db->table('product_categories')
                ->select('product_id')
                ->where('category_id', (int) $categoryId)
                ->get()
                ->getResultArray();
            $ids = array_column($ids, 'product_id');
            if ($ids) {
                $model->whereIn('id', $ids);
            } else {
                $model->where('id', 0);
            }
            $cat = $db->table('categories')->where('id', (int) $categoryId)->get()->getRowArray();
            if ($cat) {
                $title = $cat['name'] . ' - Jacquelle';
            }
        } else {
            $cat = null;
        }

        $disneyCatIds = [35177, 35178, 36413, 36414, 36415, 36416, 36417, 36893];
        $makeupCatIds = [36418, 36419, 36420];
        $categoryBanner = null;
        if ($categoryId) {
            $cid = (int) $categoryId;
            if ($cid === 41446) {
                $categoryBanner = ['image' => 'assets/images/banner_toy_story.webp', 'alt' => 'Banner Toy Story 5'];
            } elseif (in_array($cid, $disneyCatIds, true)) {
                $categoryBanner = ['image' => 'assets/images/banner_disney.webp', 'alt' => 'Banner Disney Edition'];
            } elseif (in_array($cid, $makeupCatIds, true)) {
                $categoryBanner = ['image' => 'assets/images/banner_makeup.webp', 'alt' => 'Banner Makeup'];
            }
        }

        if ($q) {
            $model->groupStart();
            $model->where('LOWER(name) LIKE', '%' . strtolower($q) . '%');
            $model->orLike('product_code', $q);
            $model->groupEnd();
        }

        if ($type === 'featured') {
            $model->where('is_featured', 1);
        } elseif ($type === 'bundle') {
            $model->where('is_bundle', 1);
        } elseif ($type === 'discount') {
            $model->where('discount_percent >', 0);
        }

        if ($stock === 'available') {
            $model->where('stock >', 0);
        }

        if ($price && isset($priceRanges[$price])) {
            [$pmin, $pmax] = $priceRanges[$price];
            $model->where('COALESCE(sale_price, price) >=', $pmin)
                  ->where('COALESCE(sale_price, price) <=', $pmax);
        }

        $products = $model->orderBy('id', 'ASC')->findAll();

        $categories = $db->table('categories')->orderBy('id', 'ASC')->get()->getResultArray();

        foreach ($products as &$p) {
            $p['old_price'] = $p['price'];
            $p['price']     = $p['sale_price'] ?? $p['price'];
        }
        unset($p);

        return view('products/index', [
            'title'      => $title,
            'heading'    => $categoryId && $cat ? $cat['name'] : ($type === 'featured' ? 'Produk Unggulan' : ($type === 'discount' ? 'Diskon' : ($type === 'bundle' ? 'Produk Bundle' : 'All Products'))),
            'products'   => $products,
            'categories' => $categories,
            'categoryId' => $categoryId ? (int) $categoryId : null,
            'categoryBanner' => $categoryBanner,
            'type'       => $type,
            'q'          => $q,
            'price'      => $price,
            'stock'      => $stock,
            'active'     => 'products',
        ]);
    }

    public function detail(int $id, ?string $slug = null)
    {
        $model = new ProductModel();
        $product = $model->find($id);

        if (! $product) {
            return $this->response->setStatusCode(404)->setBody(view('pages/placeholder', [
                'title'  => 'Produk Tidak Ditemukan - Jacquelle',
                'page'   => 'cart',
                'name'   => 'Produk Tidak Ditemukan',
                'active' => 'products',
            ]));
        }

        $product['old_price'] = $product['price'];
        $product['price']     = $product['sale_price'] ?? $product['price'];
        $product['gallery']   = $this->decodeGallery($product['images'] ?? '');
        $product['variants']  = $this->decodeVariants($product['variants'] ?? null);

        $db = \Config\Database::connect();
        $categories = $db->table('product_categories')
            ->select('categories.id, categories.name, categories.slug')
            ->join('categories', 'categories.id = product_categories.category_id')
            ->where('product_categories.product_id', (int) $id)
            ->get()
            ->getResultArray();

        $related = $model->where('id !=', $product['id'])->orderBy('id', 'RANDOM')->limit(5)->findAll();
        foreach ($related as &$r) {
            $r['old_price'] = $r['price'];
            $r['price']     = $r['sale_price'] ?? $r['price'];
        }
        unset($r);

        return view('products/detail', [
            'title'      => $product['name'] . ' - Jacquelle',
            'product'    => $product,
            'categories' => $categories,
            'related'    => $related,
            'active'     => 'products',
        ]);
    }

    private function decodeGallery($json)
    {
        $imgs = json_decode((string) $json, true);
        return is_array($imgs) ? array_values(array_filter($imgs)) : [];
    }

    private function decodeVariants($json)
    {
        $arr = json_decode((string) $json, true);
        if (! is_array($arr)) {
            return [];
        }
        $out = [];
        foreach ($arr as $v) {
            if (! is_array($v) || empty($v['name'])) {
                continue;
            }
            $out[] = [
                'name'      => $v['name'],
                'image'     => $v['image'] ?? '',
                'price'     => (int) ($v['price'] ?? 0),
                'old_price' => (int) ($v['old_price'] ?? 0),
            ];
        }
        return $out;
    }
}
