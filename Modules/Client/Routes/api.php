<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Middleware\CheckApiToken;

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

Route::group([
    'prefix' => 'client-v1',
], function () {
    // AUTH
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        Route::post('register', 'AuthController@Register');
        Route::post('/', 'AuthController@checkAuth');
        Route::post('resend-phone-verification', 'VerifyController@resendPhoneVerification');
        Route::post('verify', 'VerifyController@verify');
        Route::post('logout', 'VerifyController@logout')->middleware(CheckApiToken::class);
        Route::put('update', 'AuthController@updateProfile')->middleware(CheckApiToken::class);
        Route::post('update-avatar', 'AuthController@updateAvatar')->middleware(CheckApiToken::class);
    });
    Route::get('configs', 'GeneralController@configs');

    Route::group(['middleware'=>CheckApiToken::class],function (){
        //profile
        Route::get('client/{id}', 'ClientController@profile');
        Route::resource('address', 'AddressController');
        //home
        Route::get('brand', 'BrandController@index');
        Route::get('brand/{id}/service', 'BrandController@brandServices');
        //order
        Route::get('service/{id}/shifts', 'OrderController@serviceShifts');
        Route::post('check-promo-code', 'OrderController@checkPromoCode');
        Route::post('order', 'OrderController@store');
        Route::post('order/{id}/rate', 'OrderController@rateOrder');
        Route::post('brand_employee/{employee_id}/order/{order_id}/rate', 'OrderController@rateEmployee');
        Route::get('current-orders', 'OrderController@currentOrders');
        Route::get('all-orders', 'OrderController@allOrders');

        Route::get('order-chat/{orderId}', 'OrderChatController@messages');
        Route::post('order-chat', 'OrderChatController@store');
        //contact-admin
        Route::get('admin-chat', 'ContactController@adminChat');
        Route::post('admin-chat', 'ContactController@store');

    });


});
