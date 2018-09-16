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
//Route::get('categories/{category}', function(\App\Category $category) {
//    return $category->toJson();
//});
//Route::get('/categories/', 'CategoryController@getCategoriesApi');
//Route::get('/categories/{category}', 'CategoryController@getCategoryApi');
//Route::get('/categories/{category}/subcategories', 'CategoryController@getSubcategoriesApi');


Route::get('/mods/{game}', 'CategoryController@getGameModsCategories');
Route::get('/mods/{game}/category/{category}', 'CategoryController@getCategory');

Route::get('/mods/{game}/create-category/{category?}', 'CategoryController@createCategory');
//->middleware('auth:api')
Route::get('/mods/category/{category}/subcategories', 'CategoryController@getSubcategoriesApi');
Route::get('/mods/category/{category}/modifications', 'ModificationController@getModificationsInCategoryApi');
Route::get('/mods/{game}/category/{category}/create-modification', 'ModificationController@create');

Route::get('/mods/modifications/{mod}', 'ModificationController@getModification');
Route::get('/mods/modifications/{mod}/update', 'ModificationController@edit');

Route::resource('post','PostController');
Route::resource('comment', 'CommentController');

Route::get('/post/{id}/comments', 'CommentController@getForPostId');

Route::get('/userinfo', 'Auth\LoginController@getUserInfoApi');