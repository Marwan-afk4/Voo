<?php

use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\User\LocationController as UserLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/verify-email', [AuthenticationController::class, 'verifyEmail']);
Route::post('/forget-password', [AuthenticationController::class, 'forgetPassword']);


    Route::middleware((['auth:sanctum','IsAdmin']))->group(function () {

///////////////////////////////////////////// Countries //////////////////////////////////////////////////
        Route::get('/admin/country', [LocationController::class, 'GetCountry']);

        Route::post('/admin/country/add', [LocationController::class, 'addCountry']);

        Route::post('/admin/country/update', [LocationController::class, 'UpdateCountry']);

        Route::post('/admin/country/delete', [LocationController::class, 'DeleteCountry']);

//////////////////////////////////////////////////// Cities //////////////////////////////////////////////////
        Route::get('/admin/city', [LocationController::class, 'GetCity']);

        Route::post('/admin/city/add', [LocationController::class, 'addCity']);

        Route::post('/admin/city/update', [LocationController::class, 'UpdateCity']);

        Route::post('/admin/city/delete', [LocationController::class, 'DeleteCity']);

    });






    Route::middleware((['auth:sanctum','IsUser']))->group(function () {

        Route::get('/user/profile', [AuthenticationController::class, 'userProfile']);

        Route::post('/logout', [AuthenticationController::class, 'logout']);

        Route::get('/user/cityList', [UserLocationController::class, 'GetCity']);

        Route::get('/user/countryList', [LocationController::class, 'GetCountry']);

    });
