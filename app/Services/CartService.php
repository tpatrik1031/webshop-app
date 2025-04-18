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
            $cartItems = CartItem::where('user_id', Auth::id())->get();

            $cartItemsArray = $cartItems->map(function($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ];
            })->toArray();

            $cartItemsCollection = collect($cartItemsArray);
        } else {
            $cart = Session::get('cart', []);
            $cartItemsCollection = collect($cart);
        }

        $productIds = $cartItemsCollection->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get();

        return [$products, $cartItemsCollection];
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

            // Itt is az index-et keressük meg
            $index = $cartItems->search(function ($item) use ($productId) {
                return $item['product_id'] == $productId;
            });

            if ($index !== false) {
                $items = $cartItems->toArray();
                $items[$index]['quantity'] = $quantity;
                Session::put('cart', $items);
            }
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

            $index = $cartItems->search(function ($item) use ($productId) {
                return $item['product_id'] == $productId;
            });

            if ($index !== false) {
                $items = $cartItems->toArray();
                $items[$index]['quantity'] += $quantity;
                Session::put('cart', $items);
            } else {
                $cartItems->push(['product_id' => $productId, 'quantity' => $quantity]);
                Session::put('cart', $cartItems->toArray());
            }
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
