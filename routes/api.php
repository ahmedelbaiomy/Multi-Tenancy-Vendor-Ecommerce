<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::get('/', function () {
//    return view('front.home');
//});

Route::group(
    [
        'middleware' => 'CheckLanguage'
    ], function () {

    Route::group(['namespace'=>'Site','middleware'=>'auth:web'],function (){

    });
    Route::group(['namespace'=>'Site','middleware'=>'guest:web'],function (){

        Route::get('/test',function (){
            return 1;
        });
        Route::get('login', [LoginController::class, 'login'])->name('user.login');
        Route::post('login', [LoginController::class, 'doLogin'])->name('user.do.login');
    });

});
