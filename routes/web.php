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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');

Route::post('/mods/create-category', 'CategoryController@createCategory')->name('CreateCategory')->middleware('auth');
Route::get('/mods/{game}', 'CategoryController@getGameModsCategories')->name('GameModsCategories');
Route::get('/mods/{game}/create-category/{category?}', 'CategoryController@createCategory')->middleware('auth')->middleware('auth');

Route::get('/mods/{game}/category/{category}', 'CategoryController@getCategory')->name('ModCategory');

Route::get('/mods/modifications/{mod}', 'ModificationController@getModification')->name('ModificationView');
Route::get('/mods/modifications/{mod}/update', 'ModificationController@edit')->name('ModificationUpdate')->middleware('auth');
Route::put('/mods/modifications/{mod}/update', 'ModificationController@edit')->middleware('auth');

Route::get('/mods/modifications/{mod}/create-files', 'FileController@createModificationFiles')->name('CreateModFiles')->middleware('auth');
Route::post('/mods/modifications/{mod}/create-files', 'FileController@createModificationFiles')->middleware('auth');
Route::get('/mods/modifications/{mod}/edit-files', 'FileController@editModificationFiles')->middleware('auth');
Route::put('/mods/modifications/{mod}/edit-files', 'FileController@editModificationFiles')->middleware('auth');
Route::get('/mods/modifications/{mod}/mass-download', 'FileController@massDownload');

Route::get('/mods/modifications/{mod}/files/{file}/download', 'FileController@download');
Route::get('/mods/modifications/{mod}/files/{file}/download-with-instructions', 'FileController@downloadWithInstructions');

Route::get('/mods/modifications/{mod}/files/{file}/instruction', 'FileController@getInstruction');
Route::get('/mods/modifications/{mod}/files/{file}/instruction/{instruction}/print', 'InstructionController@showPdf');
Route::get('/mods/modifications/{mod}/files/{file}/edit-instruction/{instruction}', 'InstructionController@edit')->middleware('auth');
Route::get('/mods/modifications/{mod}/files/{file}/edit-instruction/', 'InstructionController@create')->middleware('auth');
Route::post('/mods/modifications/{mod}/files/{file}/edit-instruction/', 'InstructionController@create')->middleware('auth');
Route::post('/mods/modifications/{mod}/files/{file}/edit-instruction/{instruction}', 'InstructionController@edit')->middleware('auth');

Route::get('/mods/modifications/{mod}/create-images', 'FileController@createModificationImageFiles')->name('CreateModImages')->middleware('auth');
Route::post('/mods/modifications/{mod}/create-images', 'FileController@createModificationImageFiles')->middleware('auth');
Route::get('/mods/modifications/{mod}/edit-images', 'FileController@editModificationImageFiles')->middleware('auth');
Route::put('/mods/modifications/{mod}/edit-images', 'FileController@editModificationImageFiles')->middleware('auth');

Route::get('/mods/modifications/{mod}/edit-splash-images', 'FileController@editModificationSplashImages')->name('EditModSplash')->middleware('auth');
Route::post('/mods/modifications/{mod}/edit-splash-images', 'FileController@editModificationSplashImages')->middleware('auth');

Route::get('/mods/modifications/{mod}/edit-background-images', 'FileController@editModificationBackgroundImages')->name('EditModBackground')->middleware('auth');
Route::post('/mods/modifications/{mod}/edit-background-images', 'FileController@editModificationBackgroundImages')->middleware('auth');

Route::get('/mods/modifications/{mod}/news', 'ModificationController@getNews');
Route::get('/mods/modifications/{mod}/edit-news', 'ModificationNewsController@create')->name('CreateNews')->middleware('auth');
Route::post('/mods/modifications/{mod}/edit-news', 'ModificationNewsController@create')->middleware('auth');

Route::get('/mods/modifications/{mod}/edit-news/{news}', 'ModificationNewsController@edit')->name('EditNews')->middleware('auth');
Route::post('/mods/modifications/{mod}/edit-news/{news}', 'ModificationNewsController@edit')->middleware('auth');

Route::get('/mods/modifications/{mod}/ratings', 'ModificationController@getRatings');
Route::get('/mods/modifications/{mod}/ratings/{rating}/edit', 'ModificationRatingController@edit')->middleware('auth');
Route::put('/mods/modifications/{mod}/ratings/{rating}/edit', 'ModificationRatingController@edit')->middleware('auth');
Route::get('/mods/modifications/{mod}/create-rating', 'ModificationRatingController@create')->middleware('auth');
Route::post('/mods/modifications/{mod}/create-rating', 'ModificationRatingController@create')->middleware('auth');

Route::get('/mods/modifications/{mod}/create-videos', 'ModificationVideoController@createModificationVideos')->name('CreateModVideos');
Route::post('/mods/modifications/{mod}/create-videos', 'ModificationVideoController@createModificationVideos')->middleware('auth');
Route::get('/mods/modifications/{mod}/edit-videos', 'ModificationVideoController@editModificationVideos')->middleware('auth');
Route::put('/mods/modifications/{mod}/edit-videos', 'ModificationVideoController@editModificationVideos')->middleware('auth');

Route::get('/mods/{game}/category/{category}/create-modification', 'ModificationController@create')->middleware('auth');
Route::post('/mods/create-modification', 'ModificationController@create')->middleware('auth');
