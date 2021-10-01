<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Route for Roles
    Route::group(['prefix' => 'roles'], function(){
        Route::get('/', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles');
    });

    // Route for Users Management
    Route::group(['prefix' => 'users'], function(){
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('users_create');
        Route::get('/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users_edit');
        Route::post('/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('users_update');
        
    });
    
    // Route for Master
    Route::group(['prefix' => 'master'], function(){
        // Route for Employee
        Route::group(['prefix' => 'employees'], function(){
            Route::get('/', function(){return view('pages.master.employees.index');})->name('employees');
            Route::get('/create', function(){return view('pages.master.employees.create');})->name('employees_create');
            Route::get('/edit', function(){return view('pages.master.employees.edit');})->name('employees_edit');
        });
    });

    // Route for Categories of Service
    Route::get('/services/categories', function(){return view('pages.master.service_categories.index');})->name('services_categories');
    
    // Route User Logs
    Route::get('/user_logs', function(){return view('pages.user_management.user_logs.index');})->name('user_logs');

    // Route Profile Edit
    Route::get('/profile/edit', function(){return view('pages.profile.edit');})->name('profile_edit');
});

