<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DeliveryFeeController;
use App\Http\Controllers\DeliveryTypeController;
use App\Http\Controllers\DeliveryZoneController;
use App\Http\Controllers\ImageSliderController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\ReturnPolicyController;
use App\Http\Controllers\SingleProductController;
use App\Models\WishList;
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
/** default home route */
Route::get('/', 'HomePageController@index');
/** Authenticate routes */
Route::get('login', 'AuthController@login')->name('login');
Route::post('authenticate', 'AuthController@authenticate')->name('authenticate');
Route::post('sing-up','AuthController@store')->name('singUp');
/** Forget routes */
//--- Forget password routes
Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');
Route::get('logout', 'AuthController@logout')->name('logout');
Route::group(['middleware' => 'prevent-back-history'], function () {
    /** Admin access authentication routes */
    Route::group(['prefix' => 'admin','middleware' => ['admin']], function () {
        Route::get('dashboard', 'AuthController@index')->name('dashboard');
        Route::get('profile', 'AuthController@profile')->name('profile');
        Route::get('edit/{id}', 'AuthController@edit')->name('edit');
        Route::put('update/{id}', 'AuthController@update')->name('profile.update');
        /** password update model routes */
        Route::put('passwordupdate', 'AuthController@passwordupdate')->name('passwordupdate');
        /** products category resource route */
        Route::resource('category', CategoryController::class);
        /** Delivery zones resource route */
        Route::resource('delivery_zone', DeliveryZoneController::class);
        /** Delivery fee resource route */
        Route::resource('delivery_fee', DeliveryFeeController::class);
        /** Delivery Types resource route */
        Route::resource('delivery_types', DeliveryTypeController::class);
        /** Products resource routes */
        Route::resource('product', ProductController::class)->except(['show']);
        Route::post('product_variant', 'ProductController@productVariant')->name('productVariant');
        Route::get('product_add', 'ProductController@add')->name('product.add');
        Route::post('product_edit_variant', 'ProductController@editProductVariant')->name('editProductVariant');
        Route::post('product_variant_destroy', 'ProductController@destroyVariant')->name('product.destroyVariant');
        /** Brand resource routes */
        Route::resource('brand', BrandController::class);
        /** Manufacturer resource routes */
        Route::resource('manufacturer', ManufacturerController::class);
        /** Return policy resource routes */
        Route::resource('return_policy', ReturnPolicyController::class);
        /** Customers routes */
        Route::resource('customer', CustomerController::class);
        /** slider images */
        Route::resource('slider_image',ImageSliderController::class);
        /** orders routes */
        Route::get('orders-index','OrderController@adminIndex')->name('orders.adminIndex');
        Route::get('orders-info/{id?}','OrderController@adminOrderDetails')->name('ordersDetails.admin');
        Route::get('order-invoice/{id?}','OrderController@invoiceDownload')->name('order.invoice');
        Route::post('change-status','OrderController@statusUpdate')->name('orders.changeStatus');
    });
});
/** Frontend routes  */
Route::get('home', 'HomePageController@index')->name('home');
/** search field route */
Route::post('search','HomePageController@search')->name('search');
/** postal code popup route */
Route::post('postal_code','HomePageController@postalCheck')->name('postal');
/** product category listing page route */
Route::get('product-category/{id?}','ProductListingController@index')->name('product_list');
/** single product listing page route */
Route::get('single/{id?}','SingleProductController@index')->name('single.product.view');
/** postal check route  */
Route::post('postalCheck', 'SingleProductController@postalCodeCheck')->name('postalCheck');
/** cart route  */
Route::get('cart','CartController@index')->name('cart.index');
Route::post('cart-details','CartController@cartDetails')->name('cart.details');
Route::post('cart-destroy','CartController@destroy')->name('cart.destroy');
Route::post('cart-update','CartController@update')->name('cart.update');
/** add address route */
Route::get('address-list','AddAddressController@index')->name('address.index');
Route::get('add-address','AddAddressController@create')->name('add.address');
Route::post('address-store','AddAddressController@store')->name('address.store');
Route::get('edit-address/{id?}','AddAddressController@edit')->name('address.edit');
Route::post('update-address/{id?}','AddAddressController@update')->name('address.update');
Route::get('delete/{id?}','AddAddressController@destroy')->name('address.delete');
Route::get('default/{id?}','AddAddressController@default')->name('address.default');
/** user profile routes */
Route::get('user-profile','UserProfileController@index')->name('useProfile.index');
Route::post('user-profile-update','UserProfileController@update')->name('useProfile.update');
Route::post('user-confirmation','UserProfileController@emailConfirmation')->name('userProfile.confirm');
Route::post('confirm-code','UserProfileController@confirmCode')->name('useProfile.confirmCode');
Route::post('user-destroy','UserProfileController@destroy')->name('userProfile.destroy');
/** wish list routes */
Route::get('wishlist-view','WishListController@index')->name('wishlist.index');
Route::post('wishlist','WishListController@create_or_delete')->name('wishlist.create_or_destroy');
Route::get('wishlist-destroy/{id?}','WishListController@destroy')->name('wishlist.destroy');
/** summary page */
Route::get('summary-page','SummaryPageController@index')->name('summaryPage.index');
/** orders routes */
Route::get('orders-list','OrderController@index')->name('orders.index');
Route::post('orders-store','OrderController@store')->name('orders.store');
Route::get('order-details','OrderController@orderDetails')->name('orders.orderDetails');
