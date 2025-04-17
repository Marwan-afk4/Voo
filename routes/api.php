<?php

use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\OrgnizationController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\User\LocationController as UserLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/verify-email', [AuthenticationController::class, 'verifyEmail']);
Route::post('/forget-password', [AuthenticationController::class, 'forgetPassword']);
Route::get('/user/cityCountryList', [UserLocationController::class, 'GetCity']);
Route::post('/reset-password', [AuthenticationController::class, 'resetPassword']);


    Route::middleware((['auth:sanctum','IsAdmin']))->group(function () {

        Route::get('/admin/profile', [AuthenticationController::class, 'userProfile']);

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

/////////////////////////////////////////////////// Users ////////////////////////////////////////////////////

        Route::get('/admin/users', [UserController::class, 'getUsers']);

        Route::get('/admin/user/{id}', [UserController::class, 'getUser']);

        Route::post('/admin/user/add', [UserController::class, 'addUser']);

        Route::post('/admin/user/update/{id}', [UserController::class, 'updateUser']);

        Route::post('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);

//////////////////////////////////////////////// Orgnization //////////////////////////////////////////////////

        Route::get('/admin/organization', [OrgnizationController::class, 'getOrgnization']);

        Route::get('/admin/organization/{id}', [OrgnizationController::class, 'getOrgnizationById']);

        Route::post('/admin/organization/add', [OrgnizationController::class, 'addOrgnization']);

        Route::post('/admin/organization/update/{id}', [OrgnizationController::class, 'updateOrgnization']);

        Route::post('/admin/organization/delete/{id}', [OrgnizationController::class, 'deleteOrgnization']);


////////////////////////////////////////////////// Events ////////////////////////////////////////////////////

        Route::get('/admin/event', [EventController::class, 'getEvents']);


    });






    Route::middleware((['auth:sanctum','IsUser']))->group(function () {

        Route::get('/user/profile', [AuthenticationController::class, 'userProfile']);

        Route::post('/logout', [AuthenticationController::class, 'logout']);


    });
