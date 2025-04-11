<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    public function food(Request $request): Response
    {
        $selectedCategory = $request->query('category');

        // Ha van kategória választás, akkor csak a hozzá tartozó termékek
        if ($selectedCategory) {
            $category = ProductCategory::where('name', $selectedCategory)->first();
            if ($category) {
                $products = $category->products; // Használjuk a products kapcsolatot
            } else {
                $products = collect(); // Ha nincs ilyen kategória, üres kollekció
            }
        } else {
            // Ha nincs kategória választás, akkor az összes "food" típusú termék
            $products = Product::where('type', 'food')->get();
        }

        // Kategóriák listája a kategóriák választásához
        $categories = ProductCategory::all();

        return Inertia::render('Shop/Food/Index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    public function toy(): Response
    {
        return Inertia::render('Shop/Toy/Index');
    }

    public function accessories(): Response
    {
        return Inertia::render('Shop/Accessories/Index');
    }
}
