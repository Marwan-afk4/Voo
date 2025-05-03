<?php

use App\Http\Controllers\Api\Admin\AdminRequestController;
use App\Http\Controllers\Api\Admin\BnyadmRequstController;
use App\Http\Controllers\Api\Admin\EventController;
use App\Http\Controllers\Api\Admin\LocationController;
use App\Http\Controllers\Api\Admin\OperationController;
use App\Http\Controllers\Api\Admin\OrgnizationController;
use App\Http\Controllers\Api\Admin\TaskController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Orgnization\BnyadmRequstController as OrgnizationBnyadmRequstController;
use App\Http\Controllers\Api\Orgnization\EventController as OrgnizationEventController;
use App\Http\Controllers\Api\Orgnization\LocationController as OrgnizationLocationController;
use App\Http\Controllers\Api\Orgnization\OperationController as OrgnizationOperationController;
use App\Http\Controllers\Api\Orgnization\RequestController;
use App\Http\Controllers\Api\Orgnization\TaskController as OrgnizationTaskController;
use App\Http\Controllers\Api\Orgnization\UserController as OrgnizationUserController;
use App\Http\Controllers\Api\User\ApplyController;
use App\Http\Controllers\Api\User\BnyadmController;
use App\Http\Controllers\Api\User\HistoryController;
use App\Http\Controllers\Api\User\HomePageController;
use App\Http\Controllers\Api\User\LocationController as UserLocationController;
use App\Http\Controllers\Api\User\RequestListController;
use App\Http\Controllers\Api\User\ShakwaController;
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

        Route::delete('/admin/task/delete/{id}', [TaskController::class, 'deleteTask']);

//////////////////////////////////////////////////// Requests ////////////////////////////////////////////////////////

        Route::get('/admin/request', [AdminRequestController::class, 'getAllRequest']);

        Route::get('/admin/request/{id}', [AdminRequestController::class, 'getRequestById']);

        Route::put('/admin/request/accept/{id}', [AdminRequestController::class, 'acceptRequest']);

        Route::put('/admin/request/reject/{id}', [AdminRequestController::class, 'rejectRequest']);

        Route::delete('/admin/request/delete/{id}', [AdminRequestController::class, 'deleteRequest']);

//////////////////////////////////////////////// Shakwa and Suggest ////////////////////////////////////////////////////////

        Route::get('/admin/shakwa', [UserController::class, 'getShakawy']);

        Route::get('/admin/suggest', [UserController::class, 'getSuggests']);

//////////////////////////////////////////////////// OPERATION /////////////////////////////////////////////////////////

        Route::get('/admin/getEventDetails/{eventId}', [OperationController::class, 'getEventsDetails']);

        Route::get('/admin/getTaskDetails/{taskId}', [OperationController::class, 'getTasksDetails']);

        Route::get('/admin/getEventVolunteers/{eventId}', [OperationController::class, 'getEventVolunteers']);

        Route::get('/admin/getTaskVolunteers/{taskId}', [OperationController::class, 'getTaskVolunteers']);

        Route::put('/admin/changeEventVolunteerStatus/{volunteerId}', [OperationController::class, 'changeEventVolunteerStatus']);

        Route::put('/admin/changeTaskVolunteerStatus/{volunteerId}', [OperationController::class, 'changeTaskVolunteerStatus']);

        Route::get('/admin/getEventShakawy/{eventId}', [OperationController::class, 'getEventShakwat']);

        Route::get('/admin/getTaskShakawy/{taskId}', [OperationController::class, 'getTaskShakwat']);

        Route::get('/admin/getEventSuggest/{eventId}', [OperationController::class, 'getEventSuggest']);

        Route::get('/admin/getTaskSuggest/{taskId}', [OperationController::class, 'getTaskSuggest']);

        Route::put('/admin/readEventSuggest/{eventId}', [OperationController::class, 'ReadEventSuggest']);

        Route::put('/admin/readTaskSuggest/{taskId}', [OperationController::class, 'ReadTaskSuggest']);

////////////////////////////////////////////////////// Bnyadm /////////////////////////////////////////////////////////

        Route::get('/admin/bnyadm', [BnyadmRequstController::class, 'getBnyadmRequstList']);

        Route::get('/admin/bnyadm/{id}', [BnyadmRequstController::class, 'getBnyadmRequstDetails']);

        Route::put('/admin/bnyadm/accept/{id}', [BnyadmRequstController::class, 'acceptBnyadmRequst']);

        Route::put('/admin/bnyadm/reject/{id}', [BnyadmRequstController::class, 'rejectBnyadmRequst']);





    });






    Route::middleware((['auth:sanctum','IsUser']))->group(function () {

        Route::get('/user/profile', [AuthenticationController::class, 'userProfile']);

        Route::put('/user/profile/update', [AuthenticationController::class, 'editUserProfile']);

        Route::post('/logout', [AuthenticationController::class, 'logout']);

        Route::get('/user/eventsAndTasks', [HomePageController::class, 'getEventsAndTaks']);

        Route::get('/user/historyRequests',[HistoryController::class,'getHistoryAttend']);

        Route::get('/user/pendingApproved',[RequestListController::class,'PendingApproved']);

        Route::post('/user/Apply',[ApplyController::class,'applyFor']);

        Route::get('/user/shakwa',[ShakwaController::class,'getShakwa']);

        Route::post('/user/shakwa/add',[ShakwaController::class,'AddShakwa']);

        Route::get('/user/suggest',[ShakwaController::class,'getSuggest']);

        Route::post('/user/suggest/add',[ShakwaController::class,'AddSuggest']);

        Route::post('/user/bebnyadm',[BnyadmController::class,'BeBnyadm']);

        Route::get('/user/OrgnizationList',[ApplyController::class,'OrginizationList']);


    });




    Route::middleware((['auth:sanctum','IsOrgniazation']))->group(function () {

        Route::get('/ornization/profile', [OrgnizationUserController::class, 'OrnizationPrfile']);

        Route::put('/ornization/profile/update', [OrgnizationUserController::class, 'editOrgnizationProfile']);

        Route::get('/ornization/users', [OrgnizationUserController::class, 'getOrgnizationUsers']);

        Route::get('/ornization/user/{id}', [OrgnizationUserController::class, 'getUser']);

        Route::post('/ornization/user/add', [OrgnizationUserController::class, 'addUser']);

        Route::delete('/ornization/user/delete/{id}', [OrgnizationUserController::class, 'deleteUser']);

        Route::get('/ornization/task', [OrgnizationTaskController::class, 'getOrgnizationTasks']);

        Route::get('/ornization/task/{id}', [OrgnizationTaskController::class, 'getTaskById']);

        Route::post('/ornization/task/add', [OrgnizationTaskController::class, 'addTask']);

        Route::put('/ornization/task/update/{id}', [OrgnizationTaskController::class, 'updateTask']);

        Route::delete('/ornization/task/delete/{id}', [OrgnizationTaskController::class, 'deleteTask']);

        Route::get('/ornization/event', [OrgnizationEventController::class, 'getEvents']);

        Route::get('/ornization/event/{id}', [OrgnizationEventController::class, 'getEventById']);

        Route::post('/ornization/event/add', [OrgnizationEventController::class, 'addEvent']);

        Route::put('/ornization/event/update/{id}', [OrgnizationEventController::class, 'updateEvent']);

        Route::delete('/ornization/event/delete/{eventId}', [OrgnizationEventController::class, 'deleteEvent']);

        Route::get('/orgnization/getCountry', [OrgnizationLocationController::class, 'GetCountry']);

        Route::get('/orgnization/getCity', [OrgnizationLocationController::class, 'GetCity']);

        Route::get('/orgnization/getZone', [OrgnizationLocationController::class, 'GetZones']);

        //////

        Route::get('/orgnization/request', [RequestController::class, 'getAllRequest']);

        Route::put('/orgnization/request/accept/{id}', [RequestController::class, 'acceptRequest']);

        Route::put('/orgnization/request/reject/{id}', [RequestController::class, 'rejectRequest']);

        Route::put('/orgnization/request/attend/{id}', [RequestController::class, 'attendRequest']);

        Route::put('/orgnization/request/lost/{id}', [RequestController::class, 'lostRequest']);

    //////

        Route::get('/orgnization/getEventDetails/{eventId}', [OrgnizationOperationController::class, 'getEventsDetails']);

        Route::get('/orgnization/getTaskDetails/{taskId}', [OrgnizationOperationController::class, 'getTasksDetails']);

        Route::get('/orgnization/getEventVolunteers/{eventId}', [OrgnizationOperationController::class, 'getEventVolunteers']);

        Route::get('/orgnization/getTaskVolunteers/{taskId}', [OrgnizationOperationController::class, 'getTaskVolunteers']);

        Route::put('/orgnization/changeEventVolunteerStatus/{volunteerId}', [OrgnizationOperationController::class, 'changeEventVolunteerStatus']);

        Route::put('/orgnization/changeTaskVolunteerStatus/{volunteerId}', [OrgnizationOperationController::class, 'changeTaskVolunteerStatus']);

        Route::get('/orgnization/getEventShakawy/{eventId}', [OrgnizationOperationController::class, 'getEventShakwat']);

        Route::get('/orgnization/getTaskShakawy/{taskId}', [OrgnizationOperationController::class, 'getTaskShakwat']);

        Route::get('/orgnization/getEventSuggest/{eventId}', [OrgnizationOperationController::class, 'getEventSuggest']);

        Route::get('/orgnization/getTaskSuggest/{taskId}', [OrgnizationOperationController::class, 'getTaskSuggest']);

        Route::put('/orgnization/readEventSuggest/{eventId}', [OrgnizationOperationController::class, 'readEventSuggest']);

        Route::put('/orgnization/readTaskSuggest/{taskId}', [OrgnizationOperationController::class, 'readTaskSuggest']);

///////

        Route::get('/orgnization/bnyadm', [OrgnizationBnyadmRequstController::class, 'getBnyadmRequstList']);

        Route::get('/orgnization/bnyadm/{id}', [OrgnizationBnyadmRequstController::class, 'getBnyadmRequstDetails']);

        Route::put('/orgnization/bnyadm/accept/{id}', [OrgnizationBnyadmRequstController::class, 'acceptBnyadmRequst']);

        Route::put('/orgnization/bnyadm/reject/{id}', [OrgnizationBnyadmRequstController::class, 'rejectBnyadmRequst']);

    });
