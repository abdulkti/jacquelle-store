<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Jacquelle Effortless Lashes - Toy Story 5 Edition',
                'slug' => 'jacquelle-effortless-lashes-toy-story-5-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/PLUGO_8_1783327894452_resized512-png.webp',
                'price' => 88000,
                'sale_price' => 70400,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Jacquelle Effortless Brush 4in1 Zero Hassle - Toy Story 5 Edition',
                'slug' => 'jacquelle-effortless-brush-4in1-zero-hassle-toy-story-5-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/front_2_1_1780986980228_resized512-png.webp',
                'price' => 219000,
                'sale_price' => 175200,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Jacquelle Kangaroo 2in1 Makeup Puff - Toy Story 5 Edition',
                'slug' => 'jacquelle-kangaroo-2in1-makeup-puff-toy-story-5-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/SLIDE_2___3_-removebg-preview_1780904636631_resized512-png.webp',
                'price' => 98000,
                'sale_price' => 78400,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Jacquelle Discovery Set Eau de Parfum - Toy Story 5 Edition',
                'slug' => 'jacquelle-discovery-set-eau-de-parfum-toy-story-5-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/PLUGO_6_1780903628094_resized512-png.webp',
                'price' => 148000,
                'sale_price' => 118400,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Jacquelle Lash Obsession Mascara - Devil Wears Prada Edition - Lengthening',
                'slug' => 'jacquelle-lash-obsession-mascara-devil-wears-prada-edition-lengthening',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/product__1776752820288_resized512-png.webp',
                'price' => 139000,
                'sale_price' => 111200,
                'discount_percent' => 20,
            ],
            [
                'name' => 'HRM by House of Jacquelle - Hormonc Fragrance Intense Eau de Parfum Devil Wears Prada Edition 30ml',
                'slug' => 'hrm-by-house-of-jacquelle-hormonc-fragrance-intense-eau-de-parfum-devil-wears-prada-edition-30ml',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/Screenshot_2026-04-21_132325_1776752615985_resized512-png.webp',
                'price' => 69000,
                'sale_price' => 55200,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Jacquelle Iconique Lashes - Devil Wears Prada Edition',
                'slug' => 'jacquelle-iconique-lashes-devil-wears-prada-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/DESIGN_IGS_TIPOS_19_1776918183406_resized512-png.webp',
                'price' => 88000,
                'sale_price' => 70400,
                'discount_percent' => 20,
            ],
            [
                'name' => 'Jacquelle Dew Tint - Devil Wears Prada Edition',
                'slug' => 'jacquelle-dew-tint-devil-wears-prada-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/Screenshot_2026-04-21_115537_1776752403489_resized512-png.webp',
                'price' => 138000,
                'sale_price' => 108000,
                'discount_percent' => 21,
            ],
            [
                'name' => 'Jacquelle Blur Tinted Cushion SPF 30 PA+++ Devil Wears Prada Edition',
                'slug' => 'jacquelle-blur-tinted-cushion-spf-30-pa-devil-wears-prada-edition',
                'image' => 'https://d2kchovjbwl1tk.cloudfront.net/vendor/12533/product/COVER_CUSHION_-removebg-preview_1777883350017_resized512-png.webp',
                'price' => 199000,
                'sale_price' => 159200,
                'discount_percent' => 20,
            ],
        ];

        foreach ($data as $row) {
            $row['created_at'] = date('Y-m-d H:i:s');
            $row['updated_at'] = date('Y-m-d H:i:s');
            $this->db->table('products')->insert($row);
        }

        echo "Seeded " . count($data) . " products.\n";
    }
}
