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
    Route::get('/', [
        App\Http\Controllers\HomeController::class,
        'index',
    ])->name('home');

    Route::group(
        ['middleware' => ['permission:superadmin|user_management_access']],
        function () {
            // Route for Roles
            Route::group(['prefix' => 'roles'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'index',
                ])->name('roles');
                Route::get('/get-roles', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'getRole',
                ])->name('get_roles');
                Route::post('/store', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'store',
                ])->name('roles_store');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'update',
                ])->name('roles_update');
                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'destroy',
                ])->name('roles_destroy');

                Route::post('/rolepermission/{id}', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'rolePermission',
                ])->name('roles_permissions');
                Route::delete('/revoke', [
                    App\Http\Controllers\Admin\RoleController::class,
                    'revokePermission',
                ])->name('revoke_permission');
            });

            Route::group(['prefix' => 'permissions'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\PermissionController::class,
                    'index',
                ])->name('permissions');
                Route::post('/store', [
                    App\Http\Controllers\Admin\PermissionController::class,
                    'store',
                ])->name('permissions_store');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\PermissionController::class,
                    'update',
                ])->name('permissions_update');
                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\PermissionController::class,
                    'destroy',
                ])->name('permissions_destroy');
            });

            // Route for Users Management
            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\UserController::class,
                    'index',
                ])->name('users');
                Route::get('/create', [
                    App\Http\Controllers\Admin\UserController::class,
                    'create',
                ])->name('users_create');
                Route::post('/store', [
                    App\Http\Controllers\Admin\UserController::class,
                    'store',
                ])->name('users_store');
                Route::get('/edit/{id}', [
                    App\Http\Controllers\Admin\UserController::class,
                    'edit',
                ])->name('users_edit');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\UserController::class,
                    'update',
                ])->name('users_update');
                Route::post('/change-password/{id}', [
                    App\Http\Controllers\Admin\UserController::class,
                    'changePassword',
                ])->name('users_change_password');
                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\UserController::class,
                    'destroy',
                ])->name('users_destroy');
            });
        }
    );
    // Route for Master
    Route::group(
        [
            'prefix' => 'master',
            'middleware' => ['permission:superadmin|master_data'],
        ],
        function () {
            // Route for Employee
            Route::group(['prefix' => 'employees'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\EmployeeController::class,
                    'index',
                ])->name('employees');
                Route::get('/create', [
                    App\Http\Controllers\Admin\EmployeeController::class,
                    'create',
                ])->name('employees_create');
                Route::post('/store', [
                    App\Http\Controllers\Admin\EmployeeController::class,
                    'store',
                ])->name('employees_store');
                Route::get('/edit/{id}', [
                    App\Http\Controllers\Admin\EmployeeController::class,
                    'edit',
                ])->name('employees_edit');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\EmployeeController::class,
                    'update',
                ])->name('employees_update');
                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\EmployeeController::class,
                    'destroy',
                ])->name('employees_destroy');
            });

            // Route for Banners
            Route::group(['prefix' => 'banners'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\AssetBannerController::class,
                    'index',
                ])->name('banners');
                Route::get('/create', [
                    App\Http\Controllers\Admin\AssetBannerController::class,
                    'create',
                ])->name('banners_create');
                Route::post('/store', [
                    App\Http\Controllers\Admin\AssetBannerController::class,
                    'store',
                ])->name('banners_store');
                Route::get('/edit/{id}', [
                    App\Http\Controllers\Admin\AssetBannerController::class,
                    'edit',
                ])->name('banners_edit');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\AssetBannerController::class,
                    'update',
                ])->name('banners_update');
                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\AssetBannerController::class,
                    'destroy',
                ])->name('banners_destroy');
            });

            // Route for Services
            Route::group(['prefix' => 'services'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'index',
                ])->name('services');
                Route::get('/create', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'create',
                ])->name('services_create');
                Route::post('/store', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'store',
                ])->name('services_store');
                Route::get('/edit/{id}', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'edit',
                ])->name('services_edit');

                Route::get('/get-images/{id}', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'getImages',
                ])->name('services_images');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'update',
                ])->name('services_update');

                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\ServiceController::class,
                    'destroy',
                ])->name('services_destroy');

                // Service Categories
                Route::get('/categories', [
                    App\Http\Controllers\Admin\ServiceCategoryController::class,
                    'index',
                ])->name('services_categories');
                Route::delete('/categories/destroy', [
                    App\Http\Controllers\Admin\ServiceCategoryController::class,
                    'destroy',
                ])->name('categories_destroy');
                Route::post('/categories/update/{id}', [
                    App\Http\Controllers\Admin\ServiceCategoryController::class,
                    'update',
                ])->name('categories_update');
                Route::post('/categories/store', [
                    App\Http\Controllers\Admin\ServiceCategoryController::class,
                    'store',
                ])->name('categories_store');
            });
        }
    );

    // Route for Consumen
    Route::group(['prefix' => 'consumen'], function () {
        Route::group(['prefix' => 'transactions'], function () {
            Route::get('/', [
                App\Http\Controllers\Admin\OrderController::class,
                'index',
            ])->name('transactions');
            Route::get('/detail/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'show',
            ])->name('transactions_detail');
            Route::get('/confirmation/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'createConfirmation',
            ])->name('transactions_confirmation');
            Route::post('/confirmation/store/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'storeConfirmation',
            ])->name('create_confirmation');
            // Route::get('/edit', function(){return view('pages.master.services.edit');})->name('services_edit');
        });

        Route::group(['prefix' => 'gps-logs'], function () {
            Route::get('/', function () {
                return view('pages.consumen.gps_logs.index');
            })->name('gps_logs');
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::get('/', function () {
                return view('pages.consumen.payments.index');
            })->name('payments');
            Route::get('/detail', function () {
                return view('pages.consumen.payments.detail');
            })->name('payments_detail');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [
                App\Http\Controllers\Admin\CostumerController::class,
                'index',
            ])->name('consumen_users');
            Route::get('/edit/{id}', [
                App\Http\Controllers\Admin\CostumerController::class,
                'edit',
            ])->name('consumen_users_edit');
            Route::post('/update/{id}', [
                App\Http\Controllers\Admin\CostumerController::class,
                'update',
            ])->name('consumen_users_update');
            Route::delete('/destroy', [
                App\Http\Controllers\Admin\CostumerController::class,
                'destroy',
            ])->name('consumen_users_destroy');
        });
    });

    // Route User Logs
    Route::get('/user-logs', [
        App\Http\Controllers\Admin\LogController::class,
        'index',
    ])->name('user_logs');

    // Route Profile Edit
    Route::get('/profile/edit', function () {
        return view('pages.profile.edit');
    })->name('profile_edit');
});
