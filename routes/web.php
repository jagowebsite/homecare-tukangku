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
        Route::get('/', function(){return view('pages.user_management.roles.index');})->name('roles');
    });

    // Route for Users Management
    Route::group(['prefix' => 'users'], function(){
        Route::get('/', function(){return view('pages.user_management.user_data.index');})->name('users');
        Route::get('/create', function(){return view('pages.user_management.user_data.create');})->name('users_create');
        Route::get('/edit', function(){return view('pages.user_management.user_data.edit');})->name('users_edit');
    });
});

