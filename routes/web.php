<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
});


//auth session
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/', [LoginController::class,'guestView'])->middleware('role:guest');

Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



//seller routes

Route::post('regSeller', [AdminController::class, 'registerseller'])->name('regseller');



//authentication in middleware for user/admin
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDash'])->middleware('role:admin');



    //Customer
    Route::get('/viewProducts/{category}', [AdminController::class, 'viewProducts'])->middleware('role:customer')->name('viewProducts');
    Route::get('/seller/center/', [AdminController::class, 'showregisterCenter'])->middleware('role:customer');
    Route::get('/shop/home', [AdminController::class, 'shopHome'])->middleware('role:customer');
    Route::get('productPreview/{id}', [AdminController::class, 'viewProduct'])->middleware('role:customer')->name('productPreview');

    //adding product for vendors
    Route::post('addproduct', [AdminController::class, 'addProduct'])->name('addproduct');


    //ordering products
    Route::post('buynow', [AdminController::class, 'buyNow'])->name('buyNow');
    Route::post('addtocart', [AdminController::class, 'addtoCart'])->name('addtocart');
    Route::post('/orders/update-status/{id}', [AdminController::class, 'updateStatus']);

    //cartView

    Route::get('viewCart',[CartController::class, 'cartView'])->middleware('role:customer')->name('viewCart');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');


    //seller update
    Route::post('/seller/update-status/{id}', [AdminController::class, 'updateVendorStatus']);
    Route::get('sellerView/', [AdminController::class, 'viewPendingSellers'])->name('sellerView');
    Route::get('sellerAccepted/', [AdminController::class, 'viewAcceptedSellers'])->name('sellerAccepted');


});
