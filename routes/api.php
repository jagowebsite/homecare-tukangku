<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [
        App\Http\Controllers\API\AuthController::class,
        'login',
    ]);
    Route::post('/register', [
        App\Http\Controllers\API\AuthController::class,
        'register',
    ]);
    Route::post('/verify-email', [
        App\Http\Controllers\API\AuthController::class,
        'verifyEmail',
    ]);
    Route::post('/reset-password', [
        App\Http\Controllers\API\AuthController::class,
        'resetPassword',
    ]);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [
            App\Http\Controllers\API\AuthController::class,
            'login',
        ]);
        Route::post('/change-password', [
            App\Http\Controllers\API\AuthController::class,
            'changePassword',
        ]);
        Route::get('/user', [
            App\Http\Controllers\API\AuthController::class,
            'getUser',
        ]);
    });
});
