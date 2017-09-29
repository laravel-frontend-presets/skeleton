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
| Single page application
|--------------------------------------------------------------------------
|
| This route catches all requests and routes it to the Singe Page Application.
| If you want routes that is not send to the SPA, register them above this
| route.
|
*/
Route::get('/{all?}', 'AppController@index')->where(['all' => '.*'])->name('app');
