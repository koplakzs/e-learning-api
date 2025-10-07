<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'store']);

Route::post('login', [AuthController::class, 'auth']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('courses', [CourseController::class, 'index']);
    Route::middleware('role:dosen')->group(function () {
        Route::controller(CourseController::class)->group(function () {
            Route::post('courses', 'store');
            Route::put('courses/{id}', 'update');
            Route::delete('courses/{id}', 'destroy');
        });
    });
    Route::middleware('role:mahasiswa')->group(function () {
        Route::controller(CourseController::class)->group(function () {
            Route::post('courses/{id}/enroll', 'enroll');
        });
    });
});
