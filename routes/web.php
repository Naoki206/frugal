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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/initial_setting', 'HomeController@initialSetting')->name('income_setting');
Route::post('/add_expence', 'HomeController@addExpence')->name('add_expence');
Route::match(['get', 'post'], '/add_expence_category', 'HomeController@addExpenceCategory')->name('add_expence_category');
Route::get('/category_detail/{id}', 'HomeController@categoryDetail')->name('category_detail');
Route::match(['get', 'post'], '/edit_expence_category/{id}', 'HomeController@editExpenceCategory')->name('edit_category');
Route::get('/delete_expence_category/{id}', 'HomeController@deleteExpenceCategory')->name('delete_category');
Route::match(['get', 'post'], '/edit_expence/{id}', 'HomeController@editExpence')->name('edit_expence');
Route::get('/saving_history', 'HomeController@savingHistory')->name('saving_history');