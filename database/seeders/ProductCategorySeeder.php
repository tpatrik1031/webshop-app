<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'food' => ['Táp', 'Konzerv', 'Rágcsa', 'Vitamin'],
            'toy' => ['Labda', 'Kötél', 'Plüss', 'Rágcsa'],
            'accessories' => ['Nyakörv', 'Hám', 'Póráz', 'Lánc'],
        ];

        foreach ($categories as $type => $names) {
            foreach ($names as $name) {
                ProductCategory::create([
                    'type' => $type,
                    'name' => $name,
                ]);
            }
        }
    }
}
