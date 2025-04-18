<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Payment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Services\CartService;

class OrderController extends Controller
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        InertiaTable::updateQueryBuilderParameters('orders');

        $orders = QueryBuilder::for(Order::class)
            ->with('createdBy')
            ->defaultSort('-created_at')
            ->allowedSorts([
                'id',
                'total_price',
                'satus',
            ])
            ->paginate(
                perPage: request()->get('perPage', 10),
                page: request()->get('page', 1)
            )
            ->withQueryString();

        return Inertia::render('Orders/Index',
            [
                'orders' => $orders,
            ])->table(function (InertiaTable $table) {
            $table
                ->name('orders')
                ->perPageOptions([2, 10, 20])
                ->defaultSort('-created_at')
                ->column(key: 'id', label: 'ID', canBeHidden: false, sortable: true)
                ->column(key: 'total_price', label: 'Teljes Ár', canBeHidden: false, sortable: true)
                ->column(key: 'status', label: 'Státusz', canBeHidden: false, sortable: true)
                ->column(key: 'actions', canBeHidden: false, sortable: false)
                ->column(key: 'arrow', canBeHidden: false, sortable: false);
        });
    }

    /**
     * @param OrderRequest $request
     * @param Order $order
     * @return RedirectResponse
     */
    public function updateStatus(OrderRequest $request, Order $order): RedirectResponse
    {
        $requestData = $request->validated();

        $order->update([
            'status' => $requestData['status'],
        ]);

        return redirect(route('orders.index'))->with('success', 'Order updated successfully');
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function delete(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect(route('orders.index'))->with('success', 'Order deleted successfully');
    }

    public function create()
    {
        $user = Auth::user();

        $shippingAddress = $user->shippingAddress ?? null;

        $addressData = null;

        if ($shippingAddress) {
            $addressData = [
                'first_name' => $user->first_name ?? null,
                'last_name' => $user->last_name ?? null,
                'phone' => $user->phone ?? null,
                'country' => $shippingAddress->country ?? null,
                'zip' => $shippingAddress->zip ?? null,
                'city' => $shippingAddress->city ?? null,
                'address' => $shippingAddress->address ?? null,
            ];
        }

        list($products, $cartItems) = $this->cartService->getProductsAndCartItems();

        $total = 0;

        $cartItemsWithTitles = $cartItems->map(function ($item) use ($products, &$total) {
            $product = $products->firstWhere('id', $item['product_id']);
            $title = $product?->title ?? 'N/A';
            $price = $product?->price ?? 0;

            $lineTotal = $price * $item['quantity'];
            $total += $lineTotal;

            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'title' => $title,
                'price' => $price,
                'line_total' => $lineTotal,
            ];
        });


        return Inertia::render('UserOrder/Index', [
            'addressData' => $addressData,
            'total' => $total,
            'cartItems' => $cartItemsWithTitles,
        ]);
    }

    public function finalizeCart(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'zip' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'The Cart is empty'], 400);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'status' => 'pending',
                'total_price' => $validated['total'],
            ]);

            OrderDetail::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'country' => $validated['country'],
                'zip' => $validated['zip'],
                'city' => $validated['city'],
                'address' => $validated['address'],
            ]);

            Payment::create([
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'order_id' => $order->id,
                'amount' => $validated['total'],
                'status' => 'completed',
                'type' => $validated['payment_method'],
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price,
                ]);
            }

            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect(route('orders.create'))->with('success', 'The order was succefully created');

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
