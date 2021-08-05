<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@welcome');
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/table', 'HomeController@table');
Route::get('/user_add', 'HomeController@user_add');
Route::get('/answer', 'HomeController@answer');
Route::get('/admin_add', 'HomeController@admin_add');
Route::post('/user_add_save', 'HomeController@user_add_save');
Route::post('/ishlash', 'HomeController@ishlash');
Route::post('/natija_edit_save/{id}', 'HomeController@natija_edit_save');
Route::post('/admin_add_save', 'HomeController@admin_add_save');

Route::get('/table/delete/{id}', 'HomeController@user_delete');
Route::get('table/edit/{id}', 'HomeController@user_edit')->name('edit');


Route::post('/hisoblash', 'HomeController@hisoblash');