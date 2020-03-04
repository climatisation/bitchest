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
//    return view('welcome');
//});
// Route::get('/crypto', 'CryptoController@getPrices');

// Route::get('/crypto-prices', 'CryptoController@getCryptoList');

Auth::routes();
Route::redirect('/', '/crypto');
Route::get('/crypto', 'HomeController@index')->name('home')->middleware('isAdmin');
Route::get('crypto/{id}', 'HomeController@oneCrypto');
Route::get('/admin', 'UserController@index')->name('admin');
Route::get('/trade', 'TradeController@index')->name('trade');
Route::post('/buy/{id}', 'HomeController@buyCrypto');

Route::any('{query}',
  function() { return redirect('/'); })
  ->where('query', '.*');
