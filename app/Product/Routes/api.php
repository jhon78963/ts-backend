<?php

use App\Product\Controllers\ProductController;
use App\Product\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductController::class)->group(function(): void {
    Route::post('/products', 'create');
    Route::patch('/products/{product}', 'update');
    Route::delete('/products/{product}', 'delete');
    Route::get('/products', 'getAll');
    Route::get('/products/autocomplete', 'getAllAutocomplete');
    Route::get('/products/autocomplete/{product}', 'getAutocomplete');
    Route::get('/products/{product}', 'get');
});

Route::controller(ProductImageController::class)->group(function(): void {
    Route::post('/products/{product}/upload/image', 'add');
    Route::post('/products/{product}/upload/images', 'multipleAdd');
    Route::post('/products/{product}/remove/images', 'multipleRemove');
    Route::delete('/products/{product}/image/{path}', 'remove')->where('path', '.*');
    Route::get('/products/{product}/images', 'getAll');
});
