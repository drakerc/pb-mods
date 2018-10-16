<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/mods/{game}', 'CategoryController@getGameModsCategories');
Route::get('/mods/{game}/get-title', 'GameController@getGameTitleApi');
Route::get('/mods/{game}/category/{category}', 'CategoryController@getCategory');

Route::get('/mods/{game}/create-category/{category?}', 'CategoryController@createCategory');
//->middleware('auth:api')
Route::get('/mods/category/{category}/subcategories', 'CategoryController@getSubcategoriesApi');
Route::get('/mods/category/{category}/get-title', 'CategoryController@getCategoryTitleApi');
Route::get('/mods/category/{category}/modifications', 'ModificationController@getModificationsInCategoryApi');
Route::get('/mods/{game}/category/{category}/create-modification', 'ModificationController@create');

Route::get('/mods/modifications/{mod}', 'ModificationController@getModification');
Route::get('/mods/modifications/{mod}/get-title', 'ModificationController@getModTitleApi');
Route::get('/mods/modifications/{mod}/update', 'ModificationController@edit');
Route::delete('/mods/modifications/{mod}/delete', 'ModificationController@destroy');

Route::get('/mods/modifications/{mod}/create-files', 'FileController@createModificationFiles');
Route::get('/mods/modifications/{mod}/edit-files', 'FileController@editModificationFiles');
Route::get('/mods/modifications/{mod}/files', 'ModificationController@getFilesApi');
Route::delete('/mods/modifications/{mod}/files/{file}/delete', 'FileController@destroy');

Route::get('/mods/modifications/{mod}/create-images', 'FileController@createModificationImageFiles');
Route::get('/mods/modifications/{mod}/edit-images', 'FileController@editModificationImageFiles');
Route::get('/mods/modifications/{mod}/edit-background-images', 'FileController@editModificationBackgroundImages');
Route::get('/mods/modifications/{mod}/edit-splash-images', 'FileController@editModificationSplashImages');

Route::get('/mods/modifications/{mod}/news', 'ModificationController@getNews');
Route::get('/mods/modifications/{mod}/edit-news', 'ModificationNewsController@create');
Route::get('/mods/modifications/{mod}/edit-news/{news}', 'ModificationNewsController@edit');
Route::delete('/mods/modifications/{mod}/edit-news/{news}/delete', 'ModificationNewsController@destroy');

Route::get('/mods/modifications/{mod}/images', 'ModificationController@getImagesApi');

Route::get('/mods/modifications/{mod}/ratings', 'ModificationController@getRatings');
Route::get('/mods/modifications/{mod}/ratings/{rating}/edit', 'ModificationRatingController@edit');
Route::delete('/mods/modifications/{mod}/ratings/{rating}/delete', 'ModificationRatingController@destroy');
Route::get('/mods/modifications/{mod}/create-rating', 'ModificationRatingController@create');

Route::get('/mods/modifications/{mod}/create-videos', 'ModificationVideoController@createModificationVideos');
Route::get('/mods/modifications/{mod}/edit-videos', 'ModificationVideoController@editModificationVideos');
Route::get('/mods/modifications/{mod}/videos', 'ModificationController@getVideosApi');
Route::delete('/mods/modifications/{mod}/videos/{video}/delete', 'ModificationVideoController@destroy');

Route::resource('post','PostController');
Route::resource('comment', 'CommentController');

Route::get('/post/{id}/comments', 'CommentController@getForPostId');

Route::get('/userinfo', 'Auth\LoginController@getUserInfoApi');

