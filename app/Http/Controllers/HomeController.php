<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $foodProducts = $this->withMedia(Product::where('type', 'food')->get());
        $toyProducts = $this->withMedia(Product::where('type', 'toy')->get());
        $accessoryProducts = $this->withMedia(Product::where('type', 'accessories')->get());

        return Inertia::render('Home/Index', [
            'foodProducts' => $foodProducts,
            'toyProducts' => $toyProducts,
            'accessoryProducts' => $accessoryProducts,
        ]);
    }

    private function withMedia(Collection $products)
    {
        return $products->map(function ($product) {
            $product->image = $product->getFirstMediaUrl('default');
            return $product;
        });
    }
}
