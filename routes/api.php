<?php

use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\OrgnizationController;
use App\Http\Controllers\Api\Admin\TaskController;
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

        Route::put('/admin/country/update/{id}', [LocationController::class, 'UpdateCountry']);

        Route::delete('/admin/country/delete/{id}', [LocationController::class, 'DeleteCountry']);

//////////////////////////////////////////////////// Cities //////////////////////////////////////////////////

        Route::get('/admin/city', [LocationController::class, 'GetCity']);

        Route::post('/admin/city/add', [LocationController::class, 'addCity']);

        Route::put('/admin/city/update/{id}', [LocationController::class, 'UpdateCity']);

        Route::delete('/admin/city/delete/{id}', [LocationController::class, 'DeleteCity']);

//////////////////////////////////////////////////// Zones //////////////////////////////////////////////////

        Route::get('/admin/zone', [LocationController::class, 'GetZones']);

        Route::post('/admin/zone/add', [LocationController::class, 'addZone']);

        Route::put('/admin/zone/update/{id}', [LocationController::class, 'UpdateZone']);

        Route::delete('/admin/zone/delete/{id}', [LocationController::class, 'DeleteZone']);

/////////////////////////////////////////////////// Users ////////////////////////////////////////////////////

        Route::get('/admin/users', [UserController::class, 'getUsers']);

        Route::get('/admin/user/{id}', [UserController::class, 'getUser']);

        Route::post('/admin/user/add', [UserController::class, 'addUser']);

        Route::put('/admin/user/update/{id}', [UserController::class, 'updateUser']);

        Route::delete('/admin/user/delete/{id}', [UserController::class, 'deleteUser']);

//////////////////////////////////////////////// Orgnization //////////////////////////////////////////////////

        Route::get('/admin/organization', [OrgnizationController::class, 'getOrgnization']);

        Route::get('/admin/organization/{id}', [OrgnizationController::class, 'getOrgnizationById']);

        Route::post('/admin/organization/add', [OrgnizationController::class, 'addOrgnization']);

        Route::put('/admin/organization/update/{id}', [OrgnizationController::class, 'updateOrgnization']);

        Route::delete('/admin/organization/delete/{id}', [OrgnizationController::class, 'deleteOrgnization']);


////////////////////////////////////////////////// Events ////////////////////////////////////////////////////

        Route::get('/admin/event', [EventController::class, 'getEvents']);

        Route::get('/admin/event/{id}', [EventController::class, 'getEventById']);

        Route::post('/admin/event/add', [EventController::class, 'addEvent']);

        Route::put('/admin/event/update/{id}', [EventController::class, 'updateEvent']);

        Route::delete('/admin/event/delete/{eventId}', [EventController::class, 'deleteEvent']);

/////////////////////////////////////////////////// Tasks ////////////////////////////////////////////////////////

        Route::get('/admin/task', [TaskController::class, 'getTasks']);

        Route::get('/admin/task/{id}', [TaskController::class, 'getTaskById']);

        Route::post('/admin/task/add', [TaskController::class, 'addTask']);

        Route::put('/admin/task/update/{id}', [TaskController::class, 'updateTask']);

        Route::delete('/admin/task/delete/{taskId}', [TaskController::class, 'deleteTask']);


    });






    Route::middleware((['auth:sanctum','IsUser']))->group(function () {

        Route::get('/user/profile', [AuthenticationController::class, 'userProfile']);

        Route::post('/logout', [AuthenticationController::class, 'logout']);


    });
