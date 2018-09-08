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


Route::get('/mods/:game/', 'CategoryController@getGameModsCategoriesApi');
Route::get('/mods/category/{category}', 'CategoryController@getCategoryApi');
Route::get('/mods/category/{category}/subcategories', 'CategoryController@getSubcategoriesApi');

Route::get('/modifications/{mod}', 'ModificationController@getModificationApi');
