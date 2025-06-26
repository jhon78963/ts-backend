<?php

use App\Order\Controllers\OrderController;
use App\Order\Controllers\OrderProductController;
use Illuminate\Support\Facades\Route;

Route::controller(OrderController::class)->group(function (): void {
    Route::post('/orders', 'create');
    Route::patch('/orders/{order}', 'update');
    Route::delete('/orders/{order}', 'delete');
    Route::get('/orders', 'getAll');
    Route::get('/orders/products/autocomplete', 'getAllAutocomplete');
    Route::get('/orders/products/autocomplete/{product}', 'getAutocomplete');
    Route::get('/orders/{order}', 'get');
});

Route::controller(OrderProductController::class)->group(function (): void {
    Route::post('/orders/{order}/product/{product}', 'add');
    Route::patch('/orders/{order}/product/{product}', 'modify');
    Route::delete('/orders/{order}/product/{productId}', 'remove');
});
