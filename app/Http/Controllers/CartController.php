<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        list($products, $cartItems) = $this->cartService->getProductsAndCartItems();
        $total = 0;

        $productData = $products->map(function ($product) use ($cartItems) {
            $quantity = $cartItems->where('product_id', $product->id)->first()['quantity'] ?? 0;

            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->getFirstMediaUrl('images'),
            ];
        });

        foreach ($productData as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        return Inertia::render('Cart/Index', [
            'layout' => auth()->check() ? 'AuthenticatedLayout' : 'GuestLayout',
            'products' => $productData,
            'cartItems' => $cartItems,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->addToCart($request->product_id, $request->quantity);

        return response()->json(['status' => 'success']);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $this->cartService->removeFromCart($request->product_id);

        return response()->json(['status' => 'removed']);
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->updateCartItemQuantity($request->product_id, $request->quantity);

        return response()->json(['status' => 'updated']);
    }
}
