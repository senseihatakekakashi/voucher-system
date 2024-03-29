<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\GroupAdminController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoucherCodeController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'redirectTo'])->name('home');
    
    // Route group accessible only to users with the 'super-admin' role
    Route::group(['middleware' => ['role:super-admin']], function () {
        // Place routes or route definitions specific to 'super-admin' here
        Route::resource('/group-admins', GroupAdminController::class);
        Route::resource('/groups', GroupController::class);
        Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    });

    // Route group accessible to users with either 'super-admin' or 'group-admin' roles
    Route::group(['middleware' => ['role:super-admin|group-admin']], function () {
        // Place routes or route definitions specific to 'super-admin' or 'group-admin' here
        Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
        Route::resource('/users', UserController::class);
        Route::get('/export/{export}', [ExportController::class, 'show'])->name('export.show');
    });

    // Route group accessible only to users with the 'users' role
    Route::group(['middleware' => ['role:users']], function () {
        Route::resource('/voucher-codes', VoucherCodeController::class);
    });
});


// for a specific guard:
    
    
require __DIR__.'/auth.php';