<?php

namespace App\Http\Middleware;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'cartQuantity' => function () use ($request) {
                if ($request->user()) {
                    return CartItem::where('user_id', $request->user()->id)->sum('quantity');
                }

                $cart = session()->get('cart', []);
                return collect($cart)->sum('quantity');
            },
            'cartItems' => function () use ($request) {
                if ($request->user()) {
                    return CartItem::where('user_id', $request->user()->id)->get();
                }

                return collect(session()->get('cart', []))->values();
            },
            'products' => function () use ($request) {
                if ($request->user()) {
                    $cartItems = CartItem::where('user_id', $request->user()->id)->get();
                    $productIds = $cartItems->pluck('product_id');
                    $products = Product::whereIn('id', $productIds)->get();

                    return $products->map(function ($product) use ($cartItems) {
                        $quantity = $cartItems->where('product_id', $product->id)->first()['quantity'] ?? 0;

                        return [
                            'id' => $product->id,
                            'title' => $product->title,
                            'price' => $product->price,
                            'quantity' => $quantity,
                            'image' => $product->getFirstMediaUrl('images'),
                        ];
                    });
                }

                $sessionCart = session()->get('cart', []);
                $productIds = collect($sessionCart)->pluck('product_id');
                $products = Product::whereIn('id', $productIds)->get();

                return $products->map(function ($product) use ($sessionCart) {
                    $quantity = collect($sessionCart)->where('product_id', $product->id)->first()['quantity'] ?? 0;

                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'image' => $product->getFirstMediaUrl('images'),
                    ];
                });
            },
            'cartTotal' => function () use ($request) {
                $cartItems = $request->user()
                    ? CartItem::where('user_id', $request->user()->id)->get()
                    : collect(session()->get('cart', []));

                $productIds = $cartItems->pluck('product_id');
                $products = Product::whereIn('id', $productIds)->get();

                $total = 0;

                foreach ($products as $product) {
                    $quantity = $cartItems->where('product_id', $product->id)->first()['quantity'] ?? 0;
                    $total += $product->price * $quantity;
                }

                return $total;
            },
        ]);
    }
}
