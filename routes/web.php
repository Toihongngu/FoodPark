<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProfileController;
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


Route::group(['middleware' => 'guest'],function () {
//auth route
Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');
//Route::get('admin/forget-password', [AdminAuthController::class, 'forgetPassword'])->name('admin.forget-password');

});


//profile user
Route::group(['middleware' => ['auth','status:true']], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePasswordProfile'])->name('profile.password.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatarProfile'])->name('profile.avatar.update');
});


require __DIR__ . '/auth.php';
//home
Route::get('/', [FrontendController::class, 'index'])->name('home');

// product detail
Route::get('/product/{slug}', [FrontendController::class, 'detailProduct'])->name('product.detail');

// product model route
Route::get('/load-product-modal/{productId}', [FrontendController::class, 'loadProductModal'])->name('load-product-modal');

//add to cart
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');


//update to cart
Route::get('get-cart-products', [CartController::class, 'getCartProduct'])->name('get-cart-products');
Route::get('cart-product-remove/{rowId}', [CartController::class, 'cartProductRemove'])->name('cart-product-remove');










