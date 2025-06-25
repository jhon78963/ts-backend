<?php

use App\Sale\Controllers\SaleController;
use App\Sale\Controllers\SaleProductController;
use Illuminate\Support\Facades\Route;

Route::controller(SaleController::class)->group(function (): void {
    Route::post('/sales', 'create');
    Route::patch('/sales/{sale}', 'update');
    Route::delete('/sales/{sale}', 'delete');
    Route::get('/sales', 'getAll');
    Route::get('/sales/products/autocomplete', 'getAllAutocomplete');
    Route::get('/sales/products/autocomplete/{product}', 'getAutocomplete');
    Route::get('/sales/{sale}', 'get');
});

Route::controller(SaleProductController::class)->group(function (): void {
    Route::post('/sales/{sale}/product/{product}', 'add');
    Route::patch('/sales/{sale}/product/{product}', 'modify');
    Route::delete('/sales/{sale}/product/{product}', 'remove');
});
