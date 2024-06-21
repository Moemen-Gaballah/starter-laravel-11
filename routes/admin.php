<?php

use App\Http\Controllers\Admin\CarBrandController;
use Illuminate\Support\Facades\Route;

//Route::controller(CarBrandController::class)->group(function () {
//    Route::get('car-brands', 'index');
//    Route::post('car-brands', 'store');
////    Route::post('login-by-otp', 'loginByOtp');
////    Route::post('resent-otp', 'resentOtp');
////    Route::post('register', 'register');
////    Route::post('logout', 'logout')->middleware('auth:api');
////    Route::post('refresh', 'refresh')->middleware('auth:api');
//});

Route::apiResource('car-brands', CarBrandController::class);
