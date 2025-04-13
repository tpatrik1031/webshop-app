<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getProductsAndCartItems()
    {
        if (Auth::check()) {
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get();

            $formattedCartItems = $cartItems->mapWithKeys(function ($item) {
                return [$item->product_id => $item];
            });

            $products = Product::whereIn('id', $cartItems->pluck('product_id'))->get();

            return [$products, $formattedCartItems];
        } else {
            $cartItems = collect(Session::get('cart', []));
            $formattedCartItems = $cartItems->mapWithKeys(function ($item) {
                return [$item['product_id'] => $item];
            });

            $productIds = $cartItems->pluck('product_id');
            $products = Product::whereIn('id', $productIds)->get();

            return [$products, $formattedCartItems];
        }
    }

    public function updateCartItemQuantity($productId, $quantity)
    {
        if (Auth::check()) {
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            }
        } else {
            $cartItems = collect(Session::get('cart', []));
            $cartItems = $cartItems->map(function ($item) use ($productId, $quantity) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = $quantity;
                }
                return $item;
            });
            Session::put('cart', $cartItems->toArray());
        }
    }

    public function addToCart($productId, $quantity)
    {
        if (Auth::check()) {
            CartItem::updateOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $productId],
                ['quantity' => DB::raw("quantity + {$quantity}")]
            );
        } else {
            $cartItems = collect(Session::get('cart', []));
            $existingItem = $cartItems->firstWhere('product_id', $productId);

            if ($existingItem) {
                $existingItem['quantity'] += $quantity;
            } else {
                $cartItems->push(['product_id' => $productId, 'quantity' => $quantity]);
            }

            Session::put('cart', $cartItems->toArray());
        }
    }

    public function removeFromCart($productId)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cartItems = collect(Session::get('cart', []));
            $cartItems = $cartItems->reject(function ($item) use ($productId) {
                return $item['product_id'] == $productId;
            });
            Session::put('cart', $cartItems->toArray());
        }
    }

    public function transferCartItemsToUser($userId)
    {
        $sessionCart = Session::get('cart', []);

        foreach ($sessionCart as $item) {
            CartItem::updateOrCreate(
                ['user_id' => $userId, 'product_id' => $item['product_id']],
                ['quantity' => DB::raw("COALESCE(quantity, 0) + {$item['quantity']}")]
            );
        }

        Session::forget('cart');
    }
}
