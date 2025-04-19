<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $foodProducts = $this->withMedia(
            Product::where('type', 'food')->inRandomOrder()->take(4)->get()
        );

        $toyProducts = $this->withMedia(
            Product::where('type', 'toy')->inRandomOrder()->take(4)->get()
        );

        $accessoryProducts = $this->withMedia(
            Product::where('type', 'accessories')->inRandomOrder()->take(4)->get()
        );

        return Inertia::render('Home/Index', [
            'foodProducts' => $foodProducts,
            'toyProducts' => $toyProducts,
            'accessoryProducts' => $accessoryProducts,
            'layout' => auth()->check() ? 'AuthenticatedLayout' : 'GuestLayout',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    private function withMedia(Collection $products)
    {
        return $products->map(function ($product) {
            $product->image = $product->getFirstMediaUrl('default');
            return $product;
        });
    }

    public function aboutUs()
    {
        return Inertia::render('AboutUs/Index');
    }
}
