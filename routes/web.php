<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
})->middleware('role:guest');


//auth session
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/login', [LoginController::class,'guestView'])->middleware('role:guest');

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
    Route::put('/products/{id}', [AdminController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'destroy'])->name('products.destroy');



    //ordering products
    Route::post('buynow', [AdminController::class, 'buyNow'])->name('buyNow');
    Route::post('addtocart', [AdminController::class, 'addtoCart'])->name('addtocart');
    Route::post('/orders/update-status/{id}', [AdminController::class, 'updateStatus']);


    Route::post('/orders/assign-rider/{id}', [AdminController::class, 'assignRider']);
    Route::get('rider/dashboard', [AdminController::class, 'riderDashboard'])->middleware('role:rider');

    //cartView

    Route::get('viewCart',[CartController::class, 'cartView'])->middleware('role:customer')->name('viewCart');
    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::get('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/submit', [CartController::class, 'submit'])->name('checkout.submit');

    //orders view
    Route::get('viewOrders',[AdminController::class, 'viewMyorders'])->middleware('role:customer')->name('viewOrders');
    Route::post('/orders/{id}/cancel', [AdminController::class, 'cancel'])->name('orders.cancel');

    //PRODUCTREVIEW()
    Route::post('/review/product', [AdminController::class, 'reviewProduct'])->name('review.product');



    //seller update
    Route::post('/seller/update-status/{id}', [AdminController::class, 'updateVendorStatus']);
    Route::get('sellerView/', [AdminController::class, 'viewPendingSellers'])->middleware('role:admin')->name('sellerView');
    Route::get('sellerAccepted/', [AdminController::class, 'viewAcceptedSellers'])->middleware('role:admin')->name('sellerAccepted');
    Route::get('suspendSeller/', [AdminController::class, 'viewSuspendSellers'])->middleware('role:admin')->name('suspendSeller');
    Route::get('viewSellerProduct/{id}', [AdminController::class, 'viewProductAdmin'])->middleware('role:admin')->name('viewSellerProduct');

    Route::get('/riders', [AdminController::class, 'getRiders'])->middleware('role:admin')->name('riders');

    Route::post('create/rider', [LoginController::class, 'registerRider'])->name('create.rider');
    Route::put('update/rider/{id}', [LoginController::class, 'updateRider'])->name('update.rider');
    Route::post('create/admin', [LoginController::class, 'registerAdmin'])->name('create.admin');
    Route::put('update/admin/{id}', [LoginController::class, 'updateAdmin'])->name('update.admin');
    Route::put('update/customer/{id}', [LoginController::class, 'updateCustomers'])->name('update.customer');
    Route::get('/admin', [LoginController::class, 'profileView'])->middleware('role:admin')->name('admin');

    Route::get('/customer', [LoginController::class, 'customerProfile'])->middleware('role:admin')->name('customer');

});
