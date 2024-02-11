<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
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
    return view('auth/register');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Route group accessible only to users with the 'super-admin' role
    Route::group(['middleware' => ['role:super-admin']], function () {
        // Place routes or route definitions specific to 'super-admin' here
    });

    // Route group accessible to users with either 'super-admin' or 'group-admin' roles
    Route::group(['middleware' => ['role:super-admin|group-admin']], function () {
        // Place routes or route definitions specific to 'super-admin' or 'group-admin' here
        Route::resource('/groups', GroupController::class);
        Route::resource('/users', UserController::class);
    });

    // Route group accessible only to users with the 'users' role
    Route::group(['middleware' => ['role:users']], function () {
        // Place routes or route definitions specific to 'users' here
    });

    Route::get('/dashboard', function () {
        return view('pages.voucher-codes.index');
    })->name('dashboard');
});


// for a specific guard:
    
    
require __DIR__.'/auth.php';