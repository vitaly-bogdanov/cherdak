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

Route::get('/', 'CategoryController@index')->name('home');

Route::get('/menu/{id}', 'CategoryController@show')->name('choice');
Route::post('/ajax_menu/{id}', 'CategoryController@ajaxShow')->name('ajax_cart');

Route::post('/cart', 'CartController@add_to_cart')->name('add_to_cart');

Route::post('/show', 'CartController@view_cart')->name('view_cart');

Route::post('/plus/{id}', 'CartController@plus')->name('plus');
Route::post('/minus/{id}', 'CartController@minus')->name('minus');

Route::post('/sent', 'CartController@sent_cart')->name('sent_cart');
