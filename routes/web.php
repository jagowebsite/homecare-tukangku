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
Route::group(['prefix' => 'debug'], function () {
    Route::get('/get-invoice/{id}', [
        App\Http\Controllers\Admin\OrderController::class,
        'debugInvoice',
    ])->name('debug-get-invoice');
    Route::get('/get-letter/{id}', [
        App\Http\Controllers\Admin\OrderController::class,
        'debugLetter',
    ])->name('debug-get-letter');
});

// Auth::routes();
Route::get('/verified', function () {
    return view('auth.userverify');
})->name('user_verified');

Auth::routes(['verify' => true]);



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [
        App\Http\Controllers\HomeController::class,
        'index',
    ])->name('home');

    Route::get('/chatting-consumen', function () {
        return view('pages.chat.index');
    })->name('chatting_consumen');

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
    Route::group(['prefix' => 'setting'], function () {
        // Route for Account Bank
        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', [
                App\Http\Controllers\Admin\NotificationController::class,
                'index',
            ])->name('notifications'); 
            Route::get('/read-all', [
                App\Http\Controllers\Admin\NotificationController::class,
                'markAsRead',
            ])->name('read_all_notification'); 
            Route::get('/read/{id}', [
                App\Http\Controllers\Admin\NotificationController::class,
                'show',
            ])->name('read_notification'); 
            Route::get('/count-unread-notification', [
                App\Http\Controllers\Admin\NotificationController::class,
                'getCountUnreadNotification',
            ])->name('count_unread_notification'); 
            Route::get('/get-message-notification', [
                App\Http\Controllers\Admin\NotificationController::class,
                'getUnreadNotification',
            ])->name('get_unread_notification'); 
        });
       

       
    });
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
            Route::group(['prefix' => 'account-bank'], function () {
                Route::get('/', [
                    App\Http\Controllers\Admin\BankController::class,
                    'index',
                ])->name('bank_account');
                Route::get('/create', [
                    App\Http\Controllers\Admin\BankController::class,
                    'create',
                ])->name('account_create');
                Route::post('/store', [
                    App\Http\Controllers\Admin\BankController::class,
                    'store',
                ])->name('account_store');
                Route::get('/edit/{id}', [
                    App\Http\Controllers\Admin\BankController::class,
                    'edit',
                ])->name('account_edit');
                Route::post('/update/{id}', [
                    App\Http\Controllers\Admin\BankController::class,
                    'update',
                ])->name('account_update');
                Route::delete('/destroy', [
                    App\Http\Controllers\Admin\BankController::class,
                    'destroy',
                ])->name('account_destroy');
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
            Route::get('/get-invoice/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'getInvoice',
            ])->name('get-invoice');
            Route::get('/get-letter/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'getLetter',
            ])->name('get-letter');
            Route::get('/detail/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'show',
            ])->name('transactions_detail');
            Route::get('/cancel/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'cancelOrder',
            ])->name('transactions_cancel');
            Route::get('/confirm/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'confirmOrder',
            ])->name('transactions_confirm');

            Route::get('/confirmation/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'createConfirmation',
            ])->name('transactions_confirmation');
            Route::post('/confirmation/store/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'storeConfirmation',
            ])->name('create_confirmation');
            Route::get('/confirmation/cancel/{id}', [
                App\Http\Controllers\Admin\OrderController::class,
                'cancelDetailOrder',
            ])->name('cancel_confirmation');
            Route::delete('/destroy', [
                App\Http\Controllers\Admin\OrderController::class,
                'destroy',
            ])->name('order_destroy');
            // Route::get('/edit', function(){return view('pages.master.services.edit');})->name('services_edit');
        });

        Route::group(['prefix' => 'gps-logs'], function () {
            Route::get('/', [
                App\Http\Controllers\Admin\GpsController::class,
                'index',
            ])->name('gps_logs');
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::get('/', [
                App\Http\Controllers\Admin\PaymentController::class,
                'index',
            ])->name('payments');
            Route::get('/detail/{id}', [
                App\Http\Controllers\Admin\PaymentController::class,
                'show',
            ])->name('payments_detail');
            Route::get('/cancel/{id}', [
                App\Http\Controllers\Admin\PaymentController::class,
                'cancelPayment',
            ])->name('cancel_payment');
            Route::get('/confirm/{id}', [
                App\Http\Controllers\Admin\PaymentController::class,
                'confirmPayment',
            ])->name('confirm_payment');
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

    Route::group(['prefix' => 'complain'], function () {
        Route::get('/', [
            App\Http\Controllers\Admin\ComplainController::class,
            'index',
        ])->name('complains');
        Route::get('/status/{id}', [
            App\Http\Controllers\Admin\ComplainController::class,
            'update',
        ])->name('complains_update');
    });
    Route::group(['prefix' => 'report'], function () {
        Route::get('/service', [
            App\Http\Controllers\Admin\ReportController::class,
            'index',
        ])->name('report_service');
        Route::get('/consumen', [
            App\Http\Controllers\Admin\ReportController::class,
            'indexAllOrder',
        ])->name('report_consumen');

        Route::get('/export/service', [
            App\Http\Controllers\Admin\ReportController::class,
            'exportServiceReport',
        ])->name('export_report_service');
        Route::get('/export/all', [
            App\Http\Controllers\Admin\ReportController::class,
            'exportAllReport',
        ])->name('export_report_all');
    });

    Route::group(['prefix' => 'history'], function () {
        Route::get('/employee', [
            App\Http\Controllers\Admin\HistoryEmployeeController::class,
            'index',
        ])->name('history_employee');
        Route::get('/transaction', [
            App\Http\Controllers\Admin\HistoryOrderController::class,
            'index',
        ])->name('history_transaction');
    });

    // Route User Logs
    Route::get('/user-logs', [
        App\Http\Controllers\Admin\LogController::class,
        'index',
    ])->name('user_logs');

    // Route Profile Edit
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/edit', [
            App\Http\Controllers\Admin\UserController::class,
            'indexProfile',
        ])->name('profile_edit');
        Route::post('/update', [
            App\Http\Controllers\Admin\UserController::class,
            'updateProfile',
        ])->name('profile_update');
    });
});
