<?php

use App\Measurement\Controllers\MeasurementController;
use Illuminate\Support\Facades\Route;

Route::controller(MeasurementController::class)->group(function () {
    Route::post('/measurements', 'create');
    Route::patch('/measurements/{measurement}', 'update');
    Route::delete('/measurements/{measurement}', 'delete');
    Route::get('/measurements', 'getAll');
    Route::get('/measurements/autocomplete', 'getAllAutocomplete');
    Route::get('/measurements/autocomplete/{measurement}', 'getAutocomplete');
    Route::get('/measurements/{measurement}', 'get');
});
