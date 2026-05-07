<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthOtpController;
use App\Http\Controllers\Api\ClientController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::post('/client/register', [AuthOtpController::class, 'registerClient']);
    Route::post('/otp/request', [AuthOtpController::class, 'requestOtp']);
    Route::post('/otp/verify', [AuthOtpController::class, 'verifyOtp']);

    Route::middleware('auth:sanctum')->post('/logout', [AuthOtpController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::apiResource('admins', AdminController::class);
    Route::get('/clients', [ClientController::class, 'index']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
});
