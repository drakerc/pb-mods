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

Route::post('/mods/create-category', 'CategoryController@createCategory')->name('CreateCategory');
Route::get('/mods/{game}', 'CategoryController@getGameModsCategories')->name('GameModsCategories');
Route::get('/mods/{game}/create-category/{category?}', 'CategoryController@createCategory')->middleware('auth');

Route::get('/mods/{game}/category/{category}', 'CategoryController@getCategory')->name('ModCategory');

Route::get('/mods/modifications/{mod}', 'ModificationController@getModification')->name('ModificationView');
Route::get('/mods/modifications/{mod}/update', 'ModificationController@edit')->name('ModificationUpdate');
Route::put('/mods/modifications/{mod}/update', 'ModificationController@edit');

Route::get('/mods/modifications/{mod}/create-files', 'FileController@createModificationFiles')->name('CreateModFiles');
Route::post('/mods/modifications/{mod}/create-files', 'FileController@createModificationFiles');
Route::get('/mods/modifications/{mod}/edit-files', 'FileController@editModificationFiles');
Route::put('/mods/modifications/{mod}/edit-files', 'FileController@editModificationFiles');
Route::get('/mods/modifications/{mod}/mass-download', 'FileController@massDownload');

Route::get('/mods/modifications/{mod}/create-images', 'FileController@createModificationImageFiles')->name('CreateModImages');
Route::post('/mods/modifications/{mod}/create-images', 'FileController@createModificationImageFiles');
Route::get('/mods/modifications/{mod}/edit-images', 'FileController@editModificationImageFiles');
Route::put('/mods/modifications/{mod}/edit-images', 'FileController@editModificationImageFiles');

Route::get('/mods/modifications/{mod}/create-videos', 'ModificationVideoController@createModificationVideos')->name('CreateModVideos');
Route::post('/mods/modifications/{mod}/create-videos', 'ModificationVideoController@createModificationVideos');
Route::get('/mods/modifications/{mod}/edit-videos', 'ModificationVideoController@editModificationVideos');
Route::put('/mods/modifications/{mod}/edit-videos', 'ModificationVideoController@editModificationVideos');

Route::get('/mods/{game}/category/{category}/create-modification', 'ModificationController@create');
Route::post('/mods/create-modification', 'ModificationController@create');