<?php

use Illuminate\Http\Request;

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

// Authorization
Route::group(['prefix' => '/auth'], function () {
    Route::post('/verification', 'Api\Auth\Registration\VerificationController@generateCode');
    Route::post('/registration', 'Api\Auth\Registration\RegistrationController@registration');
    Route::post('/forgot', 'Api\Auth\ResetPassword\ForgotController@generateToken');
    Route::patch('/reset', 'Api\Auth\ResetPassword\ResetController@resetPassword');
    Route::post('/token', 'Api\Auth\Login\CustomAccessTokenController@issueUserToken');
    Route::get('/social/{platform}', 'Api\Auth\Social\SocialController@redirect')
        ->where(['platform' => 'facebook|google']);
    Route::post('/social/{platform}', 'Api\Auth\Social\SocialController@login')
        ->where(['platform' => 'facebook|google']);
});
