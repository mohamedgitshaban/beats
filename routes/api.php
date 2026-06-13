<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\Api\FootballApiController;
use App\Http\Controllers\Api\auth\AdminAuthController;
use App\Http\Controllers\Api\auth\ClientAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/signup', [AdminAuthController::class, 'signup']);
        Route::post('/verify-otp', [AdminAuthController::class, 'verifyOtp']);
        Route::post('/send_otp', [AdminAuthController::class, 'sendOtp']);
        Route::post('/login', [AdminAuthController::class, 'login']);
    });
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::apiResource('profile', ProfileController::class)->only(['show', 'update', 'destroy']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);
    });
});
Route::prefix('client')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/signup', [ClientAuthController::class, 'signup']);
        Route::post('/verify-otp', [ClientAuthController::class, 'verifyOtp']);
        Route::post('/send_otp', [ClientAuthController::class, 'sendOtp']);
        Route::post('/login', [ClientAuthController::class, 'login']);
    });
    Route::middleware(['auth:sanctum', 'role:client'])->group(function () {
        Route::apiResource('ads', AdsController::class)->only(['index', 'show']);
        Route::apiResource('faq', AdsController::class)->only(['index', 'show']);
        Route::apiResource('profile', ProfileController::class)->only(['show', 'update', 'destroy']);
        Route::post('/logout', [ClientAuthController::class, 'logout']);
    });
});


Route::match(['get', 'post'], '/football', [FootballApiController::class, 'index']);
Route::match(['get', 'post'], '/football/{method}', [FootballApiController::class, 'byMethod']);
