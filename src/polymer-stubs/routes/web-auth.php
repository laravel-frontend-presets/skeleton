<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//REGISTER ALL ROUTES THAT SHOULD NOT BE SEND TO THE SPA HERE!!!


/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
|
| These routes will handle user login and registration functionality.
| This group replaces the default Auth::routes() route group, since some
| urls are changed.
|
*/
Route::group(['namespace' => 'Auth'], function() {
    Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function() {
        //Login
        Route::post('login', 'LoginController@login');

        //Register
        Route::post('register', 'RegisterController@register');

        //Password reset
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password-reset', 'AppController@index')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');

        //Auth SPA
        Route::get('/{all?}', 'AppController@index')->where(['all' => '.*'])->name('app');
    });

    //Redirect /login to /auth/login
    Route::redirect('login', 'auth/login')->name('login');
    //Handle logout
    Route::get('logout', 'LoginController@logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Single page application
|--------------------------------------------------------------------------
|
| This route catches all requests and routes it to the Singe Page Application.
| If you want routes that is not send to the SPA, register in the top of
| this file.
|
*/
Route::get('/{all?}', 'AppController@index')->where(['all' => '.*'])->name('app');
