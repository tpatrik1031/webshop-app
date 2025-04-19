<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/addresses', [AccountController::class, 'index'])->name('account.addresses.index');
    Route::post('/profile/shipping-address', [AccountController::class, 'saveShippingAddress'])->name('account.shipping-addresses.save');
    Route::post('/profile/billing-address', [AccountController::class, 'saveBillingAddress'])->name('account.billing-addresses.save');

    // Users
    Route::get('/users/list', [UserController::class, 'index'])
        ->name('users.index');
    Route::put('/users/{user}/update', [UserController::class, 'updateStatus'])
        ->name('users.update');
    Route::delete('/users/{user}/delete', [UserController::class, 'delete'])
        ->name('users.delete');

    // Products
    Route::get('/products/list', [ProductController::class, 'index'])
        ->name('products.index');
    Route::post('/products/store', [ProductController::class, 'store'])
        ->name('products.store');
    Route::put('/products/{product}/update', [ProductController::class, 'update'])
        ->name('products.update');
    Route::delete('/products/{product}/delete', [ProductController::class, 'delete'])
        ->name('products.delete');

    // Products Category
    Route::get('/product-categories/list', [ProductCategoryController::class, 'list'])
        ->name('product-categories.list');
    Route::post('/product-categories/{id}', [ProductCategoryController::class, 'requestedCategory'])
        ->name('product-categories.show');
    Route::put('/product-categories/edit/{productCategory}', [ProductCategoryController::class, 'update'])
        ->name('product-categories.edit');
    Route::post('/product-categories', [ProductCategoryController::class, 'store'])
        ->name('product-categories.store');
     Route::delete('/product-categories/{productCategory}/delete', [ProductCategoryController::class, 'delete'])
        ->name('product-categories.delete');

    // Orders
    Route::get('/orders/list', [OrderController::class, 'index'])
        ->name('orders.index');
    Route::put('/orders/{order}/update', [OrderController::class, 'update'])
        ->name('orders.update');
    Route::delete('/orders/{order}/delete', [OrderController::class, 'delete'])
        ->name('orders.delete');

    Route::get('/orders/create', [OrderController::class, 'create'])
        ->name('orders.create');
    Route::post('/orders/finish', [OrderController::class, 'finalizeCart'])
        ->name('orders.finish');

    // Pets
    Route::get('/mypets', [PetController::class, 'index'])
        ->name('pets.index');
    Route::put('/mypets/edit/{pet}', [PetController::class, 'update'])
        ->name('pets.edit');
    Route::post('/mypets', [PetController::class, 'store'])
        ->name('pets.store');
    Route::delete('/mypets/{pet}/delete', [PetController::class, 'delete'])
        ->name('pets.delete');
});

// Home
Route::get('/home', [HomeController::class, 'index'])
    ->name('home.index');

// AboutUs
Route::get('/aboutus', [HomeController::class, 'aboutUs'])
    ->name('aboutus.index');

// Cart
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])
    ->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])
    ->name('cart.remove');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])
    ->name('cart.updateQuantity');

// Shop
Route::get('/shop/food', [ShopController::class, 'food'])
    ->name('shop.food');
Route::get('/shop/toy', [ShopController::class, 'toy'])
    ->name('shop.toy');
Route::get('/shop/accessories', [ShopController::class, 'accessories'])
    ->name('shop.accessories');
Route::get('/shop/details/{id}', [ShopController::class, 'showProductDetail'])
    ->name('shop.product.show');

require __DIR__.'/auth.php';
