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

//Route::get('/', function () {
//    return view('home');
//});

Route::get('/', 'DashboardController@index');

Route::get('add', 'ProductDataController@index')->name('add');

Route::get('/product/{id}', 'ProductDataController@product')->name('product');

Route::get('/graph/{id}', 'ProductDataController@graphData')->name('graph');

//Route::get('upcs', ['as' => 'upcs', 'uses' => 'ProductDataController@addUpcs']);

Route::post('add', ['as' => 'upcs_store', 'uses' => 'ProductDataController@storeUpcs']);

Route::post('/', ['as' => 'search', 'uses' => 'DashboardController@searchData']);