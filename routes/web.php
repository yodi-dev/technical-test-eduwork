<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::redirect('/', '/login');

Route::middleware('auth')->group(
    function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/orders', function () {
            return Inertia::render('Order/Order');
        })->name('orders');

        Route::get('/products', function () {
            return Inertia::render('Product/Product');
        })->name('products');
        Route::get('/create-product', function () {
            return Inertia::render('Product/CreateProduct');
        })->name('product.create');

        Route::get('/categories', function () {
            return Inertia::render('Category/Category');
        })->name('categories');
        Route::get('/create-category', function () {
            return Inertia::render('Category/CreateCategory');
        })->name('category.create');
    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
