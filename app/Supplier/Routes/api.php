<?php

use App\Supplier\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::controller(SupplierController::class)->group(function () {
    Route::post('/suppliers', 'create');
    Route::patch('/suppliers/{supplier}', 'update');
    Route::delete('/suppliers/{supplier}', 'delete');
    Route::get('/suppliers', 'getAll');
    Route::get('/suppliers/autocomplete', 'getAllAutocomplete');
    Route::get('/suppliers/autocomplete/{supplier}', 'getAutocomplete');
    Route::get('/suppliers/{supplier}', 'get');
});
