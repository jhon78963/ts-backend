<?php

use Illuminate\Support\Facades\Route;

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTION');
// header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Auth-Token');

foreach (glob(app_path('*/Routes/public_api.php')) as $routeFile) {
    require $routeFile;
}

Route::group(['middleware' =>  ['auth:sanctum', 'check.role']], function () {
    foreach (glob(app_path('*/Routes/api.php')) as $routeFile) {
        require $routeFile;
    }
});
