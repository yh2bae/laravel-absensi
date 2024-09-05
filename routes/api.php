<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\WorkPermitController;
use App\Http\Controllers\Api\FaceRecognitionController;

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

    Route::controller(FaceRecognitionController::class)->group(function () {
        Route::post('/face-recognition', 'update');
    });

    Route::controller(WorkPermitController::class)->group(function () {
        Route::post('/work-permit', 'store');
    });
});
