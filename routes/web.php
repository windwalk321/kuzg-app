<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Products');
})->name('home');

Route::get('/cart', function () {
    return Inertia::render('Cart');
})->name('cart');

Route::get('/product/{id}', function () {
    return Inertia::render('Product');
})->name('product');

Route::get('/checkout', function() {
    return Inertia::render('Checkout');
})->name('checkout');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', function () {
    return Inertia::render('Profile');
})->name('profile');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
