<?php

use App\Http\Controllers\API\AuthConstroller;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\GroupMembersController;
use App\Http\Controllers\API\GroupSubjectController;
use App\Http\Controllers\API\RoleUserController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthConstroller::class, 'register']);
Route::post('login', [AuthConstroller::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthConstroller::class, 'logout']);
    Route::resource('subjects', SubjectController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('groups_subjects', GroupSubjectController::class);
    Route::resource('group_members', GroupMembersController::class);
    Route::resource('role-users', RoleUserController::class);

});
