<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;
use App\Models\User;

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

Route::middleware('guest')
    ->group(function () {
        // Login
        Route::view('/auth/login', 'auth.login')->name('auth.login');
        // Forgot password
        Route::view('/auth/forgot-password', 'auth.forgot-password')->name('password.request');
        // Recover password
        Route::get('/auth/recover-password/{token}', fn(string $token) => view('auth.recover-password', compact('token')))->name('password.reset');
        // Account activation
        Route::get('/auth/activate-account/{user:register_token}', fn (User $user) => view('auth.activate-account', compact('user')))->name('auth.activate-account');
    });
Route::middleware('auth')
    ->group(function () {
        // Logout
        Route::get('/auth/logout', LogoutController::class)->name('auth.logout');
    });

Route::middleware('auth')
    ->group(function () {
        // Home
        Route::view('/', 'welcome')->name('home');
        // My profile
        Route::view('/my-profile', 'my-profile')->name('my-profile');
        // Analytics
        Route::view('/analytics', 'analytics')->name('analytics');
        // Tickets
        Route::view('/tickets', 'tickets')->name('tickets');
        // Administration
        Route::view('/administration', 'administration')->name('administration');
    });
