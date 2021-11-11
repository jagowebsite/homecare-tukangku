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
Route::get('/user-logs', [
    App\Http\Controllers\API\LogController::class,
    'index',
]);
Route::get('/gps-logs', [
    App\Http\Controllers\API\GpsController::class,
    'index',
]);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [
            App\Http\Controllers\API\AuthController::class,
            'logout',
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
        Route::get('/show/{id}', [
            App\Http\Controllers\API\ServiceController::class,
            'show',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\ServiceController::class,
            'update',
        ]);
        Route::delete('/delete/{id}', [
            App\Http\Controllers\API\ServiceController::class,
            'destroy',
        ]);
    });
    Route::group(['prefix' => 'banner'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\BannerController::class,
            'store',
        ]);
        Route::get('/show/{id}', [
            App\Http\Controllers\API\BannerController::class,
            'show',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\BannerController::class,
            'update',
        ]);
        Route::delete('/delete/{id}', [
            App\Http\Controllers\API\BannerController::class,
            'destroy',
        ]);
    });
    Route::group(['prefix' => 'category-service'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\CategoryController::class,
            'store',
        ]);
        Route::get('/show/{id}', [
            App\Http\Controllers\API\CategoryController::class,
            'show',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\CategoryController::class,
            'update',
        ]);
        Route::delete('/delete/{id}', [
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
        Route::get('/show/{id}', [
            App\Http\Controllers\API\EmployeeController::class,
            'show',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\EmployeeController::class,
            'update',
        ]);
        Route::delete('/delete/{id}', [
            App\Http\Controllers\API\EmployeeController::class,
            'destroy',
        ]);
    });
    Route::get('/complains', [
        App\Http\Controllers\API\ComplainController::class,
        'index',
    ]);
    Route::group(['prefix' => 'complain'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\ComplainController::class,
            'store',
        ]);
        Route::post('/status/{id}', [
            App\Http\Controllers\API\ComplainController::class,
            'update',
        ]);
    });
    Route::get('/role-access', [
        App\Http\Controllers\API\RoleController::class,
        'index',
    ]);
    Route::group(['prefix' => 'role-access'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\RoleController::class,
            'store',
        ]);
        Route::post('/add-permission/{id}', [
            App\Http\Controllers\API\RoleController::class,
            'rolePermission',
        ]);
        Route::delete('/delete-permission/{id}', [
            App\Http\Controllers\API\RoleController::class,
            'revokePermission',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\RoleController::class,
            'update',
        ]);
        Route::delete('/delete/{id}', [
            App\Http\Controllers\API\RoleController::class,
            'destroy',
        ]);
    });
    Route::get('/role-permission', [
        App\Http\Controllers\API\PermissionController::class,
        'index',
    ]);
    Route::group(['prefix' => 'role-permission'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\PermissionController::class,
            'store',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\PermissionController::class,
            'update',
        ]);
        Route::delete('/delete/{id}', [
            App\Http\Controllers\API\PermissionController::class,
            'destroy',
        ]);
    });

    Route::get('/user-data', [
        App\Http\Controllers\API\UserController::class,
        'index',
    ]);
    Route::group(['prefix' => 'user-data'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\UserController::class,
            'store',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\UserController::class,
            'update',
        ]);
        Route::post('/change-password/{id}', [
            App\Http\Controllers\API\UserController::class,
            'changePassword',
        ]);
        Route::delete('/delete/{id}', [
            App\Http\Controllers\API\UserController::class,
            'destroy',
        ]);
    });

    Route::get('/transactions', [
        App\Http\Controllers\API\OrderController::class,
        'index',
    ]);
    Route::group(['prefix' => 'transaction'], function () {
        Route::post('/detail/confirm/{id}', [
            App\Http\Controllers\API\OrderController::class,
            'storeConfirmation',
        ]);
        Route::post('/detail/cancel/{id}', [
            App\Http\Controllers\API\OrderController::class,
            'cancelDetailOrder',
        ]);
        Route::post('/confirm/{id}', [
            App\Http\Controllers\API\OrderController::class,
            'confirmOrder',
        ]);
        Route::post('/cancel/{id}', [
            App\Http\Controllers\API\OrderController::class,
            'cancelOrder',
        ]);
    });
    Route::get('/payments', [
        App\Http\Controllers\API\PaymentController::class,
        'index',
    ]);
    Route::group(['prefix' => 'payment'], function () {
        Route::post('/create', [
            App\Http\Controllers\API\PaymentController::class,
            'store',
        ]);
        Route::post('/update/{id}', [
            App\Http\Controllers\API\PaymentController::class,
            'update',
        ]);
        Route::post('/confirm/{id}', [
            App\Http\Controllers\API\PaymentController::class,
            'confirmPayment',
        ]);
        Route::post('/cancel/{id}', [
            App\Http\Controllers\API\PaymentController::class,
            'cancelPayment',
        ]);
    });
});
