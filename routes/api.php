<?php

use App\Http\Controllers\API\AuthConstroller;
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
});
