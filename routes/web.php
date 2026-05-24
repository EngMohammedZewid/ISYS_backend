<?php

use App\Http\Controllers\Auth\LoginController;
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
    return view('welcome');
});

// Route::get('/', [LoginController::class, 'showLoginForm'])->name('login-web');
// Route::post('/login', [LoginController::class, 'login'])->name('login-web-submit');

Route::middleware(['web.middelware'])->group(function () {
    // Route::get('/user/{id}', [QrCodeController::class, 'index'])->name('qrcode');
    // Route::post('qr-login', [UserController::class, 'qrLogin'])->name('qrcode');
    // Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('qrcode', [UserController::class, 'qrcode'])->name('qrcode');
    Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

    // Route::get('/', function () {
    //     return view('welcome');
    // });
});
