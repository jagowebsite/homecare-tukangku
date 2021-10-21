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
Route::get('/services', [
    App\Http\Controllers\API\ServiceController::class,
    'index',
]);
Route::get('/banners', [
    App\Http\Controllers\API\BannerController::class,
    'index',
]);
Route::get('/category-services', [
    App\Http\Controllers\API\CategoryController::class,
    'index',
]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [
            App\Http\Controllers\API\ServiceController::class,
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
        Route::patch('/update-user', [
            App\Http\Controllers\API\AuthController::class,
            'update',
        ]);
        Route::post('/change-image', [
            App\Http\Controllers\API\AuthController::class,
            'updateImage',
        ]);
        Route::post('/change-image', [
            App\Http\Controllers\API\AuthController::class,
            'updateImage',
        ]);
        Route::post('/change-ktp-image', [
            App\Http\Controllers\API\AuthController::class,
            'updateKtpImage',
        ]);
    });
    Route::group(['prefix' => 'service'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\ServiceController::class,
            'store',
        ]);
        Route::get('/detail/{id}', [
            App\Http\Controllers\API\ServiceController::class,
            'show',
        ]);
        Route::get('/update/{id}', [
            App\Http\Controllers\API\ServiceController::class,
            'update',
        ]);
        Route::post('/delete/{id}', [
            App\Http\Controllers\API\ServiceController::class,
            'destroy',
        ]);
    });
    Route::group(['prefix' => 'banner'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\BannerController::class,
            'store',
        ]);
        Route::get('/detail/{id}', [
            App\Http\Controllers\API\BannerController::class,
            'show',
        ]);
        Route::get('/update/{id}', [
            App\Http\Controllers\API\BannerController::class,
            'update',
        ]);
        Route::post('/delete/{id}', [
            App\Http\Controllers\API\BannerController::class,
            'destroy',
        ]);
    });
    Route::group(['prefix' => 'category-service'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\CategoryController::class,
            'store',
        ]);
        Route::get('/detail/{id}', [
            App\Http\Controllers\API\CategoryController::class,
            'show',
        ]);
        Route::get('/update/{id}', [
            App\Http\Controllers\API\CategoryController::class,
            'update',
        ]);
        Route::post('/delete/{id}', [
            App\Http\Controllers\API\CategoryController::class,
            'destroy',
        ]);
    });
    Route::get('/employees', [
        App\Http\Controllers\API\EmployeeController::class,
        'index',
    ]);
    Route::group(['prefix' => 'employee'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\EmployeeController::class,
            'store',
        ]);
        Route::get('/detail/{id}', [
            App\Http\Controllers\API\EmployeeController::class,
            'show',
        ]);
        Route::get('/update/{id}', [
            App\Http\Controllers\API\EmployeeController::class,
            'update',
        ]);
        Route::post('/delete/{id}', [
            App\Http\Controllers\API\EmployeeController::class,
            'destroy',
        ]);
    });
});
