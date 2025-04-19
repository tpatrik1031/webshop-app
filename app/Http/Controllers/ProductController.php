<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends Controller
{
    public function index()
    {
        InertiaTable::updateQueryBuilderParameters('products');

        $products = QueryBuilder::for(Product::class)
            ->with(['createdBy', 'media'])
            ->defaultSort('-created_at')
            ->allowedSorts([
                'id',
                'title',
                'created_at',
            ])
            ->paginate(
                perPage: request()->get('perPage', 10),
                page: request()->get('page', 1)
            )
            ->withQueryString();

        $productCategory = ProductCategory::get();
        $productCategory = $productCategory->isEmpty() ? null : $productCategory;

        return Inertia::render('Products/Index',
            [
                'products' => $products,
                'productCategory' => $productCategory,
            ])->table(function (InertiaTable $table) {
            $table
                ->name('products')
                ->perPageOptions([2, 10, 20])
                ->defaultSort('-created_at')
                ->column(key: 'id', label: 'ID', canBeHidden: false, sortable: true)
                ->column(key: 'image', label: 'Kép', canBeHidden: false, sortable: false)
                ->column(key: 'title', label: 'Név', canBeHidden: false, sortable: true)
                ->column(key: 'price', label: 'Ár', canBeHidden: false, sortable: true)
                ->column(key: 'actions', canBeHidden: false, sortable: false)
                ->column(key: 'arrow', canBeHidden: false, sortable: false);
        });
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function store(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();

        $product = Product::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'type' => $data['type'],
            'category_id' => $data['category'],
            'created_by' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $product->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return redirect(route('products.index'))->with('success', 'Successfully created the product');
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $requestData = $request->validated();

        $product->update([
            'title' => $requestData['title'],
            'description' => $requestData['description'],
            'price' => $requestData['price'],
            'type' => $requestData['type'],
            'category_id' => $requestData['category'],
            'updated_by' => Auth::id(),
        ]);

        if ($request->hasFile('image')) {
            $product->clearMediaCollection('images');
            $product->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return redirect(route('products.index'))->with('success', 'Product updated successfully');
    }


    /**
     * @param Product $product
     * @return RedirectResponse
     */
    public function delete(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect(route('products.index'))->with('success', 'Product deleted successfully');
    }
}
