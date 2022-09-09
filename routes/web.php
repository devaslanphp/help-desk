<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogoutController;

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
    });
