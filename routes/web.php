<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminMiddleware;
// use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Middleware\MergeGuestCart;
use App\Http\Controllers\ProfileController;

// Route::get('/', function () {
//     return Inertia::render('Products');
// })->name('home');

// Route::get('/cart', function () {
//     return Inertia::render('Cart');
// })->name('cart');

Route::get('/product/{id}', function ($id) {
    return Inertia::render('Product' , [
        'id' => $id,
    ]);
})->name('product');

Route::get('/checkout', function() {
    return Inertia::render('Checkout');
})->name('checkout');

Route::get('/dashboard', [UserController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    // ... other auth routes
});

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/categories', [ProductController::class, 'categories'])->name('products.categories');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('product');
Route::get('/categories/{category}/products', [ProductController::class, 'index']);

Route::middleware([AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    // Products
    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('admin.products.destroy');
});

Route::middleware([MergeGuestCart::class])->group(function () {
    // For both guest and authenticated users
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addItem'])->name('cart.add');
    Route::put('/cart/update/{itemId}', [CartController::class, 'updateItem'])->name('cart.update');
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeItem'])->name('cart.remove');
    
    // For merging guest cart with user cart after login
    Route::post('/cart/merge', [CartController::class, 'mergeCarts'])
        ->middleware('auth')
        ->name('cart.merge');

    
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
