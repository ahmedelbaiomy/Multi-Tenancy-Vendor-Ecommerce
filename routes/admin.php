<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\TagController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\AttributeController;
use App\Http\Controllers\Dashboard\OptionController;
use App\Http\Controllers\Dashboard\SliderController;
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

        ##################################### tags #########################################
        Route::group(['prefix' => 'tags'], function () {

            Route::get('/',[TagController::class,'index'])->name('admin.tags');
            Route::get('create',[TagController::class,'create'])->name('admin.tags.create');
            Route::post('store',[TagController::class,'store'])->name('admin.tags.store');
            Route::get('edit/{id}',[TagController::class,'edit'])->name('admin.tags.edit');
            Route::post('update/{id}',[TagController::class,'update'])->name('admin.tags.update');
            Route::get('destroy/{id}',[TagController::class,'destroy'])->name('admin.tags.destroy');
        });
        ##################################### end tags #####################################
        ##################################### products #########################################
        Route::group(['prefix' => 'products'], function () {

            Route::get('/',[ProductController::class,'index'])->name('admin.products');
            Route::get('create',[ProductController::class,'create'])->name('admin.products.create');
            Route::post('store',[ProductController::class,'store'])->name('admin.products.store');
            Route::get('edit/{id}',[ProductController::class,'edit'])->name('admin.products.edit');
            Route::post('update/{id}',[ProductController::class,'update'])->name('admin.products.update');
            Route::get('destroy/{id}',[ProductController::class,'destroy'])->name('admin.products.destroy');

            //images
            Route::get('images/{id}',[ProductController::class,'uploadImages'])->name('admin.products.images');
            Route::post('storeImages',[ProductController::class,'storeImages'])->name('admin.products.storeImages');
            Route::post('storeImages/DB',[ProductController::class,'storeImagesDB'])->name('admin.products.storeImagesDB');
            Route::post('deleteImage/{img}',[ProductController::class,'deleteImage'])->name('admin.products.deleteImage');
        });
        ##################################### end products #####################################
        ##################################### attributes #########################################
        Route::group(['prefix' => 'attributes'], function () {

            Route::get('/',[AttributeController::class,'index'])->name('admin.attributes');
            Route::get('create',[AttributeController::class,'create'])->name('admin.attributes.create');
            Route::post('store',[AttributeController::class,'store'])->name('admin.attributes.store');
            Route::get('edit/{id}',[AttributeController::class,'edit'])->name('admin.attributes.edit');
            Route::post('update/{id}',[AttributeController::class,'update'])->name('admin.attributes.update');
            Route::get('destroy/{id}',[AttributeController::class,'destroy'])->name('admin.attributes.destroy');
        });
        ##################################### end attributes #####################################
        ##################################### options #########################################
        Route::group(['prefix' => 'options'], function () {

            Route::get('/',[OptionController::class,'index'])->name('admin.options');
            Route::get('create',[OptionController::class,'create'])->name('admin.options.create');
            Route::post('store',[OptionController::class,'store'])->name('admin.options.store');
            Route::get('edit/{id}',[OptionController::class,'edit'])->name('admin.options.edit');
            Route::post('update/{id}',[OptionController::class,'update'])->name('admin.options.update');
            Route::get('destroy/{id}',[OptionController::class,'destroy'])->name('admin.options.destroy');
        });
        ##################################### end options #####################################

        ################################## sliders ######################################
        Route::group(['prefix' => 'sliders'], function () {

            Route::get('/',[SliderController::class,'uploadImages'])->name('admin.sliders.create');
            Route::post('storeImages',[SliderController::class,'storeImages'])->name('admin.sliders.storeImages');
            Route::post('storeImages/DB',[SliderController::class,'storeImagesDB'])->name('admin.sliders.storeImagesDB');
            Route::get('deleteImage/{img}',[SliderController::class,'deleteImage'])->name('admin.sliders.deleteImage');

        });
        ################################## end sliders    #######################################


    });

    Route::group(['namespace' => 'Dashboard', 'middleware' => 'guest:admin','prefix'=>'admin'], function () {
        Route::get('login', [LoginController::class, 'login'])->name('admin.login');
        Route::post('login', [LoginController::class, 'doLogin'])->name('admin.do.login');
    });
});

