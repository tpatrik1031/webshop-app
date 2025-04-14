<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{

    public function list()
    {
        $productCategory = ProductCategory::all();

        return response()->json([
            'productCategories' => $productCategory,
        ]);
    }

    public function requestedCategory($id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        return response()->json([
            'id' => $productCategory->id,
            'name' => $productCategory->name,
            'type' => $productCategory->type,
        ]);
    }

    /**
     * @param ProductCategoryRequest $request
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function store(ProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $data = $request->validated();
        Log::info('Incoming product category create request', [
            'request_data' => $data,
        ]);

        $productCategory->create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);

        return redirect(route('products.index'))->with('success', 'Successfully created the product');
    }

    /**
     * @param ProductCategoryRequest $request
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $requestData = $request->validated();

        $productCategory->update([
            'name' => $requestData['name'],
            'type' => $requestData['type'],
        ]);

        return redirect(route('products.index'))->with('success', 'Product updated successfully');
    }


    /**
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function delete(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->delete();

        return redirect(route('products.index'))->with('success', 'Product deleted successfully');
    }
}
