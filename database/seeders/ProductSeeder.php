<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Keyboards',
                'slug' => 'keyboards',
                'description' => 'لوحات مفاتيح احترافية للأعمال والمكاتب',
                'image' => 'products/keyboard.jpg',
            ],
            [
                'name' => 'Mouse',
                'slug' => 'mouse',
                'description' => 'ماوس دقيق بأداء عالي',
                'image' => 'products/mouse.jpg',
            ],
            [
                'name' => 'Graphics Cards',
                'slug' => 'graphics-cards',
                'description' => 'بطاقات رسومية قوية للأعمال',
                'image' => 'products/gpu.jpg',
            ],
            [
                'name' => 'Printers',
                'slug' => 'printers',
                'description' => 'طابعات عالية الجودة',
                'image' => 'products/printer.jpg',
            ],
            [
                'name' => 'Cameras',
                'slug' => 'cameras',
                'description' => 'أنظمة مراقبة وتصوير حديثة',
                'image' => 'products/camera.jpg',
            ],
            [
                'name' => 'PC Cases',
                'slug' => 'pc-cases',
                'description' => 'صناديق حاسب احترافية',
                'image' => 'products/case.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'image' => $product['image'],
                    'is_active' => true,
                ]
            );
        }
    }
}
