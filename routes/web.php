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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::post('/mods/create-category', 'CategoryController@createCategoryWeb')->name('CreateCategory');
Route::get('/mods/{game}', 'CategoryController@getGameModsCategoriesWeb')->name('GameModsCategories');
Route::get('/mods/{game}/create-category/{category?}', 'CategoryController@getCategoryCreateWeb')->middleware('auth');

Route::get('/mods/{game}/category/{category}', 'CategoryController@getCategoryWeb')->name('ModCategory');

Route::get('/mods/modifications/{mod}', 'ModificationController@getModificationWeb');
Route::get('/modifications/create', 'ModificationController@getModificationWeb');

//Route::get('/categories/', 'CategoryController@getCategoriesWeb')->name('categories');
//Route::get('/categories/{category}', 'CategoryController@getCategoryWeb');

Route::group(['prefix' => 'voyager/admin'], function () {
    Voyager::routes();
});
