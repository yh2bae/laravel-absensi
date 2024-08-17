<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', 'getUser');
        Route::post('/logout', 'logout');
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/company', [CompanyController::class, 'getCompany']);

    Route::controller(AttendanceController::class)->group(function () {
        Route::get('/attendance', 'index');
        Route::post('/attendance/checkin', 'checkin');
        Route::post('/attendance/checkout', 'checkout');
        Route::get('/attendance/is-checkin', 'isCheckedin');
    });
});
