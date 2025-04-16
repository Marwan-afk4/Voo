<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/verify-email', [AuthenticationController::class, 'verifyEmail']);
Route::post('/forget-password', [AuthenticationController::class, 'forgetPassword']);


    Route::middleware((['auth:sanctum','IsAdmin']))->group(function () {

    });


    Route::middleware((['auth:sanctum','IsUser']))->group(function () {

        Route::get('/user/profile', [AuthenticationController::class, 'userProfile']);

        Route::post('/logout', [AuthenticationController::class, 'logout']);

    });
