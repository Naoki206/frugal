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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/initial_setting', 'HomeController@initialSetting')->name('income_setting');
Route::post('/add_expence', 'HomeController@addExpence')->name('add_expence');
Route::match(['get', 'post'], '/add_expence_category', 'HomeController@addExpenceCategory')->name('add_expence_category');