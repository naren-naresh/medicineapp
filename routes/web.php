<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryFeeController;
use App\Http\Controllers\DeliveryTypeController;
use App\Http\Controllers\DeliveryZoneController;
use App\Http\Controllers\ProductController;
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

/** Authenticate routes */
Route::get('login', 'AuthController@login')->name('login');
Route::post('authenticate', 'AuthController@authenticate')->name('authenticate');
/** Forget routes */
//--- Forget password routes
Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');
Route::group(['middleware' => 'prevent-back-history'], function () {
    /** Admin access authentication routes */
    Route::group(['middleware' => ['admin']], function () {
        Route::get('dashboard', 'AuthController@index')->name('dashboard');
        Route::get('logout', 'AuthController@logout')->name('logout');
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
        /** Products routes */
        Route::resource('product',ProductController::class);
        // Route::get('product','ProductController@basicInfo')->name('product.basicInfo');
        // Route::post('product','ProductController@postBasicInfo')->name('product.basicInfo.post');
    });
});
