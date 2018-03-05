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
| This group replaces the default Auth::routes() route group, since other
| urls are used instead.
|
*/
Route::group(['prefix' => 'auth', 'middleware' => ['guest']], function() {
    Route::get('/{all?}', 'Auth\SinglePageLoginController@index')->where(['all' => '.*'])->name('auth');
});
//Preserve original url's by setting up redirects.
Route::redirect('/login', '/auth/login');
Route::redirect('/logout', '/auth/logout');

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
