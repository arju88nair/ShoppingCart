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

Route::view('/', 'welcome');

Auth::routes();


/*
 * User and Home routes
 */

Route::get('/home', 'HomeController@index')
    ->name('home');

Route::get('/cart', 'UserController@cart')
    ->name('cart');

Route::get('/getProducts', 'UserController@getProducts')
    ->name('getProducts');

Route::get('/AddToCart', 'UserController@addToCart')
    ->name('addToCart');

Route::get('/RemoveItem', 'UserController@removeItem')
    ->name('removeItem');

Route::get('/admin', 'AdminController@admin')
    ->middleware('is_admin')
    ->name('admin');


/**
 * Product routes
 */
Route::get('/productDetail', 'ProductController@productDetail')
    ->name('productDetail');


/**
 * Redemption routes
 */

Route::get('/checkCode', 'UserController@checkCode')
    ->name('checkCode');


