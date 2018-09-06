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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::get('/categories/', 'CategoryController@getCategoriesWeb')->name('categories');
Route::get('/categories/{category}', 'CategoryController@getCategoryWeb');


Route::get('/modifications/{mod}', 'ModificationController@getModificationWeb');
Route::get('/modifications/create', 'ModificationController@getModificationWeb');
