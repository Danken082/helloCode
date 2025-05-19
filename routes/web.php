<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('welcome');
});


//auth session
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::view('/', 'user.login')->middleware('role:guest');

Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//seller routes

Route::post('regSeller', [AdminController::class, 'registerseller'])->name('regseller');



//authentication in middleware for user/admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', fn () => view('admin.dashboard'))->middleware('role:admin');
    Route::get('/seller/center/', [AdminController::class, 'showregisterCenter'])->middleware('role:customer');
    Route::get('/shop/home', fn () => view('user.shop.home'))->middleware('role:customer');
});
