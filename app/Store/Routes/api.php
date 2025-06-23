<?php

use App\Store\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::controller(StoreController::class)->group(function() {
    Route::post('/stores', 'create');
    Route::patch('/stores/{store}', 'update');
    Route::delete('/stores/{store}', 'delete');
    Route::get('/stores', 'getAll');
    Route::get('/stores/{store}', 'get');
});
