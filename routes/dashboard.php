<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth',
    'as' => 'dashboard.',
    'prefix' => 'dashboard',
], function(){
    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force_delete', [CategoriesController::class, 'force_delete'])->name('categories.force_delete');
    Route::resource('/categories', CategoriesController::class);

    Route::get('/products/trash', [ProductsController::class, 'trash'])-> name('products.trash');
    Route::put('/products/{product}/restore', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('/products/{product}/force_delete', [ProductsController::class, 'force_delete'])->name('products.force_delete');
    Route::resource('/products', ProductsController::class);
});

