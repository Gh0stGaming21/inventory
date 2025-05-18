<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Role management routes
    Route::middleware(['role:admin'])->group(function () {
        Route::patch('/profile/{user}/role', [ProfileController::class, 'updateRole'])->name('profile.role.update');
    });

    // Product routes
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('/products/{product}/update-quantity', [\App\Http\Controllers\ProductController::class, 'updateQuantity'])->name('products.update-quantity');
    
    // Category routes
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
});

require __DIR__.'/auth.php';
