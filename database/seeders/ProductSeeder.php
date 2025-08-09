<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'قميص رجالي',
                'description' => 'قميص قطن مريح بتصميم عصري',
                'price' => 120.00,
                'image' => 'https://dummyimage.com/300x300/cccccc/000000&text=Shirt'
            ],
            [
                'name' => 'حذاء رياضي',
                'description' => 'حذاء خفيف ومتين للجري',
                'price' => 250.50,
                'image' => 'https://dummyimage.com/300x300/cccccc/000000&text=Shoes'
            ],
            [
                'name' => 'ساعة يد',
                'description' => 'ساعة أنيقة ضد الماء',
                'price' => 450.99,
                'image' => 'https://dummyimage.com/300x300/cccccc/000000&text=Watch'
            ],
            [
                'name' => 'سماعة بلوتوث',
                'description' => 'صوت نقي وبطارية تدوم طويلاً',
                'price' => 180.00,
                'image' => 'https://dummyimage.com/300x300/cccccc/000000&text=Bluetooth+Headset'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

