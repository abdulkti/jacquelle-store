<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        $newProductIds = [5, 27, 20, 26, 34, 21, 28, 22, 65];
        $products = $this->getOrderedProducts($productModel, $newProductIds);

        $section2Ids = [5, 27, 20, 26];
        $section2 = $this->getOrderedProducts($productModel, $section2Ids);

        $section3Ids = [17, 9, 35, 40, 49, 39, 38, 1];
        $section3 = $this->getOrderedProducts($productModel, $section3Ids);

        $section4Ids = [24, 15, 19, 57, 64, 30, 69, 59, 14];
        $section4 = $this->getOrderedProducts($productModel, $section4Ids);

        $heroBanners = [
            ['image' => 'assets/images/hero.webp', 'link' => '/categories/41446/toy-story-5'],
        ];

        $banners = [
            'assets/images/banner_81k.webp',
            'assets/images/banner_toy_story.webp',
            'assets/images/banner_disney.webp',
            'assets/images/banner_makeup.webp',
        ];

        $slides = [
            'assets/videos/vid1.mp4',
            'assets/videos/vid2.mp4',
            'assets/videos/vid3.mp4',
            'assets/videos/vid4.mp4',
            'assets/videos/vid5.mp4',
        ];

        $data = [
            'title'       => 'Jacquelle',
            'products'    => $products,
            'section2'    => $section2,
            'section3'    => $section3,
            'section4'    => $section4,
            'banners'     => $banners,
            'heroBanners' => $heroBanners,
            'slides'      => $slides,
            'active'      => 'home',
        ];

        return view('home/index', $data);
    }

    private function getOrderedProducts($model, $ids)
    {
        $products = $model->whereIn('id', $ids)->findAll();
        $ordered = [];
        foreach ($ids as $id) {
            foreach ($products as $p) {
                if ((int)$p['id'] === (int)$id) {
                    $p['old_price'] = $p['price'];
                    $p['price']     = $p['sale_price'] ?? $p['price'];
                    $ordered[] = $p;
                    break;
                }
            }
        }
        return $ordered;
    }
}
