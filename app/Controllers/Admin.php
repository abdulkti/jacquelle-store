<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Admin extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    private function requireAdmin()
    {
        if (! session()->get('isLoggedIn') || session()->get('is_admin') != 1) {
            return redirect()->to('/auth/login')->with('error', 'Akses khusus admin. Silakan masuk dengan akun admin.');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $productModel = new ProductModel();

        $products = $productModel->orderBy('id', 'DESC')->findAll(50);
        foreach ($products as &$p) {
            $p['old_price'] = $p['price'];
            $p['price']     = $p['sale_price'] ?: $p['price'];
        }
        unset($p);

        return view('admin/index', [
            'title'    => 'Dashboard Admin - Jacquelle',
            'active'   => 'admin',
            'tab'      => 'dashboard',
            'stats'    => [
                'products'   => $this->db->table('products')->countAll(),
                'users'      => $this->db->table('users')->countAll(),
                'categories' => $this->db->table('categories')->countAll(),
                'discounts'  => $this->db->table('products')->where('discount_percent >', 0)->countAllResults(),
                'pending_orders' => $this->db->table('orders')->where('status', 'pending')->countAllResults(),
            ],
            'products' => $products,
            'users'    => (new UserModel())->orderBy('id', 'ASC')->findAll(50),
        ]);
    }

    public function products()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $products = (new ProductModel())->orderBy('id', 'DESC')->findAll(500);
        foreach ($products as &$p) {
            $p['old_price'] = $p['price'];
            $p['price']     = $p['sale_price'] ?: $p['price'];
            $p['cats']      = array_column($this->db->table('product_categories')->where('product_id', $p['id'])->get()->getResultArray(), 'category_name');
        }
        unset($p);

        return view('admin/products', [
            'title'    => 'Kelola Produk - Jacquelle',
            'active'   => 'admin',
            'tab'      => 'products',
            'products' => $products,
            'count'    => count($products),
        ]);
    }

    public function productForm($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $product = null;
        if ($id) {
            $product = (new ProductModel())->find($id);
            if (! $product) {
                return redirect()->to('/admin/products')->with('error', 'Produk tidak ditemukan.');
            }
            $product['cats'] = array_column(
                $this->db->table('product_categories')->where('product_id', $id)->get()->getResultArray(),
                'category_id'
            );
        }

        return view('admin/product_form', [
            'title'      => ($id ? 'Edit' : 'Tambah') . ' Produk - Jacquelle',
            'active'     => 'admin',
            'tab'        => 'products',
            'product'    => $product,
            'categories' => $this->db->table('categories')->orderBy('name')->get()->getResultArray(),
        ]);
    }

    public function productSave()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $id   = (int) $this->request->getPost('id');
        $name = trim($this->request->getPost('name'));

        $rules = [
            'name'             => 'required|min_length[3]',
            'price'            => 'required|integer|greater_than_equal_to[0]',
            'sale_price'       => 'permit_empty|integer|greater_than_equal_to[0]',
            'discount_percent' => 'permit_empty|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $salePrice = null;
        if ($this->request->getPost('sale_price') !== null && $this->request->getPost('sale_price') !== '') {
            $salePrice = (int) $this->request->getPost('sale_price');
        }
        $discount  = (int) $this->request->getPost('discount_percent');
        if ($salePrice && $salePrice > 0) {
            $discount = $discount > 0 ? $discount : round((1 - $salePrice / max((int) $this->request->getPost('price'), 1)) * 100);
        }

        $slug = $this->request->getPost('slug') ?: $this->slugify($name);
        $model = new ProductModel();

        if ($id) {
            $existing = $model->where('slug', $slug)->where('id !=', $id)->first();
            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'Slug sudah dipakai produk lain.');
            }
        } else {
            $base = $slug;
            $i    = 2;
            while ($model->where('slug', $slug)->first()) {
                $slug = $base . '-' . $i++;
            }
        }

        $data = [
            'name'             => $name,
            'slug'             => $slug,
            'price'            => (int) $this->request->getPost('price'),
            'sale_price'       => $salePrice,
            'discount_percent' => $discount,
            'product_code'     => $this->request->getPost('product_code') ?: null,
            'description'      => $this->request->getPost('description') ?: null,
        ];

        $variants = [];
        foreach (preg_split('/\R/', (string) $this->request->getPost('variants')) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $parts = array_map('trim', explode('|', $line));
            if (($parts[0] ?? '') === '') {
                continue;
            }
            $variants[] = [
                'name'      => $parts[0],
                'image'     => $parts[1] ?? '',
                'price'     => (int) ($parts[2] ?? 0),
                'old_price' => (int) ($parts[3] ?? 0),
            ];
        }
        $data['variants'] = $variants ? json_encode($variants, JSON_UNESCAPED_SLASHES) : null;
        $data['variant_title'] = trim((string) $this->request->getPost('variant_title')) ?: null;

        if ($file = $this->request->getFile('image')) {
            if ($file->isValid() && ! $file->hasMoved()) {
                if (! $file->isValid()) {
                    return redirect()->back()->withInput()->with('error', $file->getErrorString());
                }
                $ext = $file->getExtension();
                if (! in_array(strtolower($ext), ['webp', 'jpg', 'jpeg', 'png'])) {
                    return redirect()->back()->withInput()->with('error', 'Format gambar harus webp/jpg/png.');
                }
                $newname = 'p' . time() . '.' . $ext;
                $file->move(ROOTPATH . 'public/assets/images/products', $newname);
                $data['image'] = 'assets/images/products/' . $newname;
            }
        }

        if ($id) {
            $model->update($id, $data);
            $productId = $id;
            $msg       = 'Produk berhasil diperbarui.';
        } else {
            $productId = $model->insert($data);
            $msg       = 'Produk berhasil ditambahkan.';
        }

        $this->db->table('product_categories')->where('product_id', $productId)->delete();
        foreach ($this->request->getPost('categories') ?: [] as $catId) {
            $catName = $this->db->table('categories')->where('id', (int) $catId)->get()->getRow('name');
            if ($catName) {
                $this->db->table('product_categories')->insert([
                    'product_id'    => $productId,
                    'category_id'   => (int) $catId,
                    'category_name' => $catName,
                ]);
            }
        }

        return redirect()->to('/admin/products')->with('success', $msg);
    }

    public function productDelete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $model = new ProductModel();
        $p     = $model->find($id);
        if ($p) {
            $this->db->table('product_categories')->where('product_id', $id)->delete();
            $model->delete($id);
            if ($p['image'] && strpos($p['image'], 'http') !== 0 && is_file(ROOTPATH . 'public/' . $p['image'])) {
                @unlink(ROOTPATH . 'public/' . $p['image']);
            }
        }

        return redirect()->to('/admin/products')->with('success', 'Produk dihapus.');
    }

    public function categories()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $cats = $this->db->table('categories')->orderBy('id')->get()->getResultArray();
        foreach ($cats as &$c) {
            $c['products'] = $this->db->table('product_categories')->where('category_id', $c['id'])->countAllResults();
        }
        unset($c);

        return view('admin/categories', [
            'title'      => 'Kelola Kategori - Jacquelle',
            'active'     => 'admin',
            'tab'        => 'categories',
            'categories' => $cats,
        ]);
    }

    public function categoryForm($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $category = null;
        if ($id) {
            $category = $this->db->table('categories')->where('id', (int) $id)->get()->getRowArray();
            if (! $category) {
                return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan.');
            }
        }

        return view('admin/category_form', [
            'title'    => ($id ? 'Edit' : 'Tambah') . ' Kategori - Jacquelle',
            'active'   => 'admin',
            'tab'      => 'categories',
            'category' => $category,
        ]);
    }

    public function categorySave()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $id   = (int) $this->request->getPost('id');
        $name = trim($this->request->getPost('name'));
        if ($name === '') {
            return redirect()->back()->withInput()->with('error', 'Nama kategori wajib diisi.');
        }

        $slug = $this->request->getPost('slug') ?: $this->slugify($name);
        $builder = $this->db->table('categories');

        if ($id) {
            $existing = $builder->where('slug', $slug)->where('id !=', $id)->get()->getRow();
            if ($existing) {
                return redirect()->back()->withInput()->with('error', 'Slug sudah dipakai kategori lain.');
            }
            $builder->where('id', $id)->update(['name' => $name, 'slug' => $slug]);
            $this->db->table('product_categories')->where('category_id', $id)->update(['category_name' => $name]);
            $msg = 'Kategori berhasil diperbarui.';
        } else {
            $base = $slug;
            $i    = 2;
            while ($builder->where('slug', $slug)->get()->getRow()) {
                $slug = $base . '-' . $i++;
            }
            $builder->insert(['name' => $name, 'slug' => $slug]);
            $id  = (int) $this->db->insertID();
            $msg = 'Kategori berhasil ditambahkan.';
        }

        return redirect()->to('/admin/categories')->with('success', $msg);
    }

    public function categoryDelete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $this->db->table('product_categories')->where('category_id', (int) $id)->delete();
        $this->db->table('categories')->where('id', (int) $id)->delete();

        return redirect()->to('/admin/categories')->with('success', 'Kategori dihapus.');
    }

    public function users()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('admin/users', [
            'title'  => 'Kelola User - Jacquelle',
            'active' => 'admin',
            'tab'    => 'users',
            'users'  => (new UserModel())->orderBy('id', 'ASC')->findAll(500),
        ]);
    }

    public function userSave()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $id    = (int) $this->request->getPost('id');
        $model = new UserModel();
        $user  = $model->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'name'     => trim($this->request->getPost('name')) ?: $user['name'],
            'phone'    => $this->request->getPost('phone') ?: null,
            'is_admin' => (int) $this->request->getPost('is_admin') === 1 ? 1 : 0,
        ];

        $password = $this->request->getPost('password');
        if ($password !== null && $password !== '') {
            if (strlen($password) < 6) {
                return redirect()->back()->with('error', 'Password minimal 6 karakter.');
            }
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui.');
    }

    public function userDelete($id)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $id = (int) $id;
        if ($id === (int) session()->get('id')) {
            return redirect()->to('/admin/users')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        (new UserModel())->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User dihapus.');
    }

    public function orders()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $statuses = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];
        $status   = $this->request->getGet('status');

        $builder = $this->db->table('orders');
        if ($status && in_array($status, $statuses, true)) {
            $builder->where('status', $status);
        }
        $orders = $builder->orderBy('id', 'DESC')->limit(200)->get()->getResultArray();

        foreach ($orders as &$o) {
            $o['items']     = $this->db->table('order_items')->where('order_id', $o['id'])->countAllResults();
            $o['first_img'] = $this->db->table('order_items')->select('product_image')->where('order_id', $o['id'])->orderBy('id')->get()->getRowArray()['product_image'] ?? null;
        }
        unset($o);

        $statRows = $this->db->table('orders')->select('status, COUNT(*) AS c')->groupBy('status')->get()->getResultArray();
        $stats    = array_fill_keys($statuses, 0);
        foreach ($statRows as $r) {
            $stats[$r['status']] = (int) $r['c'];
        }

        return view('admin/orders', [
            'title'    => 'Pesanan Masuk - Jacquelle',
            'active'   => 'admin',
            'tab'      => 'orders',
            'orders'   => $orders,
            'stats'    => $stats,
            'statuses' => $statuses,
            'filter'   => $status,
        ]);
    }

    public function orderStatus()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $id     = (int) $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $allowed = ['pending', 'paid', 'shipped', 'completed', 'cancelled'];

        if (! in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $order = $this->db->table('orders')->where('id', $id)->get()->getRowArray();
        if (! $order) {
            return redirect()->to('/admin/orders')->with('error', 'Pesanan tidak ditemukan.');
        }

        $this->db->table('orders')->where('id', $id)->update([
            'status'     => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/orders' . ($order['status'] !== $status ? '' : ''))
            ->with('success', 'Status pesanan ' . $order['order_number'] . ' diubah menjadi ' . ucfirst($status) . '.');
    }

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = str_replace(['&', '%', '+'], ['dan', '', ''], $text);
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text) ?? '';
        $text = trim($text, '-');

        return $text !== '' ? $text : 'item';
    }
}
