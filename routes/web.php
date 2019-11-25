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

Route::get('/{pub?}', 'ContactController@index')->name('contact.index');
Route::get('/add/{contact}', 'ContactController@add')->name('contact.add');

Route::resource('contact', 'ContactController', ['except' => ['index', 'show']])->middleware('auth');
Route::get('/contact/{contact}', 'ContactController@show')->name('contact.show');
