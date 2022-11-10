<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\BrandController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'auth:admin','prefix'=>'admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');


        Route::group(['prefix' => 'settings'], function () {
            Route::get('shipping-methods/{type}', [SettingsController::class, 'editShippingMethods'])->name('edit.shipping.methods');
            Route::put('shipping-methods/{id}', [SettingsController::class, 'updateShippingMethods'])->name('update.shipping.methods');
        });

        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('edit.admin.profile');
            Route::put('update-profile', [ProfileController::class, 'updateProfile'])->name('update.admin.profile');
        });

        ##################################### categories #########################################
        Route::group(['prefix' => 'categories'], function () {

            Route::get('/',[CategoryController::class,'index'])->name('admin.categories');
            Route::get('create',[CategoryController::class,'create'])->name('admin.categories.create');
            Route::post('store',[CategoryController::class,'store'])->name('admin.categories.store');
            Route::get('edit/{id}',[CategoryController::class,'edit'])->name('admin.categories.edit');
            Route::post('update/{id}',[CategoryController::class,'update'])->name('admin.categories.update');
            Route::get('destroy/{id}',[CategoryController::class,'destroy'])->name('admin.categories.destroy');
        });
        ##################################### end categories #####################################

        ##################################### brands #########################################
        Route::group(['prefix' => 'brands'], function () {

            Route::get('/',[BrandController::class,'index'])->name('admin.brands');
            Route::get('create',[BrandController::class,'create'])->name('admin.brands.create');
            Route::post('store',[BrandController::class,'store'])->name('admin.brands.store');
            Route::get('edit/{id}',[BrandController::class,'edit'])->name('admin.brands.edit');
            Route::post('update/{id}',[BrandController::class,'update'])->name('admin.brands.update');
            Route::get('destroy/{id}',[BrandController::class,'destroy'])->name('admin.brands.destroy');
        });
        ##################################### end brands #####################################

    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin','prefix'=>'admin'], function () {
        Route::get('login', [LoginController::class, 'login'])->name('admin.login');
        Route::post('login', [LoginController::class, 'doLogin'])->name('admin.do.login');
    });
});

