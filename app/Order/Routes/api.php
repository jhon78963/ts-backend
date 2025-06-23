<?php

use App\Order\Controllers\OrderController;
use App\Order\Controllers\OrderProductController;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)->group(function(): void {
    Route::post('/orders', 'create');
    Route::patch('/orders/{order}', 'update');
    Route::delete('/orders/{order}', 'delete');
    Route::get('/orders', 'getAll');
    Route::get('/orders/{order}', 'get');
});

Route::controller(OrderProductController::class)->group(function(): void {
    Route::post('/orders/{order}/product/{productId}', 'add');
    Route::patch('/orders/{order}/product/{productId}', 'modify');
    Route::delete('/orders/{order}/product/{productId}', 'remove');
});

// Route::controller(ProductImageController::class)->group(function(): void {
//     Route::post('/products/{product}/upload/image', 'add');
//     Route::post('/products/{product}/upload/images', 'multipleAdd');
//     Route::post('/products/{product}/remove/images', 'multipleRemove');
//     Route::delete('/products/{product}/image/{path}', 'remove')->where('path', '.*');
//     Route::get('/products/{product}/images', 'getAll');
// });
