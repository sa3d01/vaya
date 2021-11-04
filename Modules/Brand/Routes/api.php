<?php

use Illuminate\Support\Facades\Route;
use Modules\Brand\Http\Middleware\CheckApiToken;
Route::group([
    'prefix' => 'brand-v1',
], function () {
    // AUTH
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::post('/', 'AuthController@checkAuth');
        Route::post('resend-phone-verification', 'VerifyController@resendPhoneVerification');
        Route::post('verify', 'VerifyController@verify');
        Route::post('logout', 'VerifyController@logout')->middleware(CheckApiToken::class);
        Route::put('update', 'AuthController@updateProfile')->middleware(CheckApiToken::class);
        Route::post('update-avatar', 'AuthController@updateAvatar')->middleware(CheckApiToken::class);
    });
    // Slider
    Route::group(['prefix' => 'slider','middleware'=>CheckApiToken::class], function () {
        Route::get('/', 'SliderController@index');
    });
    // Services
    Route::group(['prefix' => 'service','middleware'=>CheckApiToken::class], function () {
        Route::get('/', 'ServiceController@index');
        Route::post('/', 'ServiceController@store');
        Route::put('{id}', 'ServiceController@update');
        Route::delete('{id}', 'ServiceController@destroy');
    });
    //Employee
    Route::group(['prefix' => 'employee','middleware'=>CheckApiToken::class], function () {
        Route::get('/', 'EmployeeController@index');
        Route::post('/', 'EmployeeController@store');
        Route::put('{id}', 'EmployeeController@update');
        Route::delete('{id}', 'EmployeeController@destroy');
    });
});

