<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Site\HomeController;
use \App\Http\Controllers\Site\CategoryController;
use \App\Http\Controllers\Site\WishlistController;
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

Route::get('logout', function(){
    auth()->logout();
    Session()->flush();
    return \Illuminate\Support\Facades\Redirect::to('/');
})->name('logout');


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {

    Route::group(['namespace'=>'Site','middleware'=>'auth:web'],function (){

    });

    Route::group(['namespace'=>'Site'],function (){
        Route::get('/',[HomeController::class,'home'])->name('home');
        Route::get('category/{slug}',[CategoryController::class,'getProductsBySlug'])->name('category');

    });

    Route::group(['namespace' => 'Site', 'middleware' => 'auth'], function () {

        Route::post('wishlist', [WishlistController::class,'store'])->name('wishlist.store');

        Route::delete('wishlist', [WishlistController::class,'destroy'])->name('wishlist.destroy');
        Route::get('wishlist/products', [WishlistController::class,'index'])->name('wishlist.products.index');
    });

});
