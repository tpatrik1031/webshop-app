<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $types = [
            'food' => [
                'categories' => range(1, 4),
                'image' => storage_path('app/public/food.webp'),
            ],
            'toy' => [
                'categories' => range(5, 8),
                'image' => storage_path('app/public/toy.jpg'),
            ],
            'accessories' => [
                'categories' => range(9, 12),
                'image' => storage_path('app/public/accessories.webp'),
            ],
        ];

        foreach ($types as $type => $data) {
            $categoryIds = $data['categories'];
            $imagePath = $data['image'];
            $categoryCount = count($categoryIds);

            for ($i = 0; $i < 25; $i++) {
                $product = Product::create([
                    'title' => ucfirst($faker->words(2, true)),
                    'description' => $faker->sentence(),
                    'price' => $faker->randomFloat(2, 5, 100),
                    'type' => $type,
                    'category_id' => $categoryIds[$i % $categoryCount],
                ]);

                if (file_exists($imagePath)) {
                    $product
                        ->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            }
        }
    }
}
