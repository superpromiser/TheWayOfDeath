<?php

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

Route::group(['middleware' => 'auth:api', 'prefix'=>'v1'], function () {
    Route::post('/logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Auth\UserController@current');

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
    
    //userRole API
    Route::get('userRole', 'UserRoleController@getUserRole');
    Route::post('userRole', 'UserRoleController@createUserRole');
    Route::put('userRole', 'UserRoleController@updateUserRole');
    Route::delete('userRole', 'UserRoleController@deleteUserRole');

    //upload file
    Route::post('file/image','UploadController@imageUpload');
    Route::post('file/other','UploadController@otherUpload');
    Route::post('file/video','UploadController@videoUpload');
    Route::delete('file','UploadController@deleteFile');

    //school
    Route::get('school','SchoolController@getSchool')->name('getSchool');
    Route::post('school','SchoolController@storeSchool')->name('storeSchool');
    Route::put('school','SchoolController@updateSchool')->name('updateSchool');
    Route::delete('school','SchoolController@removeSchool')->name('removeSchool');
    Route::post('school/manager','SchoolController@storeManager')->name('storeManager');
    Route::get('school/manager','SchoolController@getManager')->name('getManager');
    Route::put('school/manager','SchoolController@updateManager')->name('updateManager');
    Route::delete('school/manager','SchoolController@removeManager')->name('removeManager');

});

Route::group(['middleware' => 'guest:api','prefix' => 'v1'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
