<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class OrderController extends Controller
{
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
    public function update(OrderRequest $request, Order $order): RedirectResponse
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
}
