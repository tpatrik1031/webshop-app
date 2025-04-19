<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

class ShopController extends Controller
{
    public function food(Request $request): Response
    {
        $selectedCategory = $request->query('category');

        if ($selectedCategory) {
            $category = ProductCategory::where('name', $selectedCategory)->first();
            if ($category) {
                $products = $category->products()
                    ->where('type', 'food')
                    ->with('media')
                    ->paginate(20)
                    ->withQueryString();
            } else {
                $products = new LengthAwarePaginator([], 0, 20);
            }
        } else {
            $products = Product::where('type', 'food')
                ->with('media')
                ->paginate(20)
                ->withQueryString();
        }

        $categories = ProductCategory::where('type', 'food')->get();

        return Inertia::render('Shop/Food/Index', [
            'products' => $products->through(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'media' => $product->getMedia('images')->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->getUrl(),
                        ];
                    }),
                ];
            }),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'layout' => auth()->check() ? 'AuthenticatedLayout' : 'GuestLayout',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function toy(Request $request): Response
    {
        $selectedCategory = $request->query('category');

        if ($selectedCategory) {
            $category = ProductCategory::where('name', $selectedCategory)->first();
            if ($category) {
                $products = $category->products()
                    ->where('type', 'toy')
                    ->with('media')
                    ->paginate(20)
                    ->withQueryString();
            } else {
                $products = new LengthAwarePaginator([], 0, 20);
            }
        } else {
            $products = Product::where('type', 'toy')
                ->with('media')
                ->paginate(20)
                ->withQueryString();
        }

        $categories = ProductCategory::where('type', 'toy')->get();

        return Inertia::render('Shop/Toy/Index', [
            'products' => $products->through(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'media' => $product->getMedia('images')->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->getUrl(),
                        ];
                    }),
                ];
            }),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'layout' => auth()->check() ? 'AuthenticatedLayout' : 'GuestLayout',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function accessories(Request $request): Response
    {
        $selectedCategory = $request->query('category');

        if ($selectedCategory) {
            $category = ProductCategory::where('name', $selectedCategory)->first();
            if ($category) {
                $products = $category->products()
                    ->where('type', 'accessories')
                    ->with('media')
                    ->paginate(20)
                    ->withQueryString();
            } else {
                $products = new LengthAwarePaginator([], 0, 20);
            }
        } else {
            $products = Product::where('type', 'accessories')
                ->with('media')
                ->paginate(20)
                ->withQueryString();
        }

        $categories = ProductCategory::where('type', 'accessories')->get();

        return Inertia::render('Shop/Accessories/Index', [
            'products' => $products->through(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'media' => $product->getMedia('images')->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'url' => $media->getUrl(),
                        ];
                    }),
                ];
            }),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'layout' => auth()->check() ? 'AuthenticatedLayout' : 'GuestLayout',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    public function showProductDetail($id): Response
    {
        $product = Product::findOrFail($id);

        $product->load('media');

        return Inertia::render('Shop/Detail/Show', [
            'product' => [
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'price' => $product->price,
                'media' => $product->getMedia('images')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                    ];
                }),
            ],
            'layout' => auth()->check() ? 'AuthenticatedLayout' : 'GuestLayout',
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}
