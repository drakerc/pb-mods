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

// AUTH
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'ApiAuthController@login');
    Route::post('signup', 'ApiAuthController@signup');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'ApiAuthController@logout');
        Route::get('user', 'ApiAuthController@user');
        Route::post('update-user-data', 'ApiAuthController@updateUserData');
        Route::post('update-user-password', 'ApiAuthController@updateUserPassword');

    });
});

Route::get('/mods/{game}', 'CategoryController@getGameModsCategories');
Route::get('/mods/{game}/get-title', 'GameController@getGameTitleApi');
Route::get('/mods/{game}/category/{category}', 'CategoryController@getCategory');

Route::get('/mods/{game}/create-category/{category?}', 'CategoryController@createCategory')->middleware('auth:api');
Route::get('/mods/category/{category}/subcategories', 'CategoryController@getSubcategoriesApi');
Route::get('/mods/category/{category}/get-title', 'CategoryController@getCategoryTitleApi');
Route::get('/mods/category/{category}/modifications', 'ModificationController@getModificationsInCategoryApi');
Route::get('/mods/{game}/category/{category}/create-modification', 'ModificationController@create')->middleware('auth:api');

Route::get('/mods/modifications/{mod}', 'ModificationController@getModification');
Route::get('/mods/modifications/{mod}/get-title', 'ModificationController@getModTitleApi');
Route::get('/mods/modifications/{mod}/update', 'ModificationController@edit')->middleware('auth:api');
Route::delete('/mods/modifications/{mod}/delete', 'ModificationController@destroy')->middleware('auth:api');

Route::get('/mods/modifications/user-mods/{user}', 'ModificationController@getUserMods');

Route::get('/mods/modifications/{mod}/create-files', 'FileController@createModificationFiles')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/edit-files', 'FileController@editModificationFiles')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/files', 'ModificationController@getFilesApi');
Route::delete('/mods/modifications/{mod}/files/{file}/delete', 'FileController@destroy')->middleware('auth:api');

Route::get('/mods/modifications/{mod}/files/{file}/instructions', 'FileController@getInstructions');
Route::get('/mods/modifications/{mod}/files/{file}/edit-instruction/', 'InstructionController@create')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/files/{file}/edit-instruction/{instruction}', 'InstructionController@edit')->middleware('auth:api');
Route::delete('/mods/modifications/{mod}/files/{file}/edit-instruction/{instruction}/delete', 'InstructionController@destroy')->middleware('auth:api');

Route::get('/mods/modifications/{mod}/create-images', 'FileController@createModificationImageFiles')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/edit-images', 'FileController@editModificationImageFiles')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/edit-background-images', 'FileController@editModificationBackgroundImages')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/edit-splash-images', 'FileController@editModificationSplashImages')->middleware('auth:api');

Route::get('/mods/modifications/{mod}/news', 'ModificationController@getNews');
Route::get('/mods/modifications/{mod}/edit-news', 'ModificationNewsController@create')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/edit-news/{news}', 'ModificationNewsController@edit')->middleware('auth:api');
Route::delete('/mods/modifications/{mod}/edit-news/{news}/delete', 'ModificationNewsController@destroy')->middleware('auth:api');

Route::get('/mods/modifications/{mod}/images', 'ModificationController@getImagesApi');

Route::get('/mods/modifications/{mod}/ratings', 'ModificationController@getRatings');
Route::get('/mods/modifications/{mod}/ratings/{rating}/edit', 'ModificationRatingController@edit')->middleware('auth:api');
Route::delete('/mods/modifications/{mod}/ratings/{rating}/delete', 'ModificationRatingController@destroy')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/create-rating', 'ModificationRatingController@create')->middleware('auth:api');

Route::get('/mods/modifications/{mod}/create-videos', 'ModificationVideoController@createModificationVideos')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/edit-videos', 'ModificationVideoController@editModificationVideos')->middleware('auth:api');
Route::get('/mods/modifications/{mod}/videos', 'ModificationController@getVideosApi');
Route::delete('/mods/modifications/{mod}/videos/{video}/delete', 'ModificationVideoController@destroy')->middleware('auth:api');

// POST
Route::get('/post/{id}/comments', 'CommentController@getForPostId');
Route::group(['middleware' => 'auth:api'], function() {
   Route::put('/post/{id}', 'PostController@update');
});
Route::resource('post','PostController')->except([
    'update'
]);

// COMMENT
Route::group(['middleware' => 'auth:api'], function () {
   Route::post('comment', 'CommentController@store');
   Route::delete('comment/{id}', 'CommentController@destroy');
});

Route::resource('comment', 'CommentController')->except([
    'store', 'destroy'
]);

// GAME
Route::get('game/search', 'GameController@searchByPhraseInTitleOrDescription');
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('game', 'GameController@store');
    Route::post('game/{id}/gallery/upload', 'GameController@uploadImages');
    Route::post('game/{id}/gallery/delete', 'GameController@deleteImages');
});
Route::resource('game', 'GameController')->except([
    'store'
]);

// POST-CATEGORY
Route::resource('post-category', 'PostCategoryController');

// USER
Route::get('/userinfo', 'Auth\LoginController@getUserInfoApi');

// GAME CATEGORIES
Route::get('game-categories', 'CategoryController@getGameCategories');

// DEV STUDIOS
Route::get('/devstudios', 'DevelopmentStudioController@index')->name('DevStudiosIndex');
Route::get('/devstudios/my-studios', 'DevelopmentStudioController@myStudios')->middleware('auth:api');
Route::get('/devstudios/user-studios/{user}', 'DevelopmentStudioController@userStudios');
Route::get('/devstudios/find/{id}', 'DevelopmentStudioController@findById');
Route::get('/devstudios/{studio}', 'DevelopmentStudioController@details')->name('DevStudiosDetails');
Route::get('/devstudios/{studio}/mods', 'DevelopmentStudioController@mods');
Route::get('/devstudios/{studio}/games', 'DevelopmentStudioController@games');
Route::get('/devstudios/{studio}/edit', 'DevelopmentStudioController@edit')->middleware('auth:api');
Route::put('/devstudios/{studio}/edit', 'DevelopmentStudioController@edit')->middleware('auth:api');
Route::delete('/devstudios/{studio}/delete', 'DevelopmentStudioController@destroy')->middleware('auth:api');
Route::post('/devstudios/{studio}/members/add', 'DevelopmentStudioController@addMember')->middleware('auth:api');
Route::delete('/devstudios/{studio}/members/delete', 'DevelopmentStudioController@deleteMember')->middleware('auth:api');
Route::get('/devstudios/create', 'DevelopmentStudioController@create')->middleware('auth:api');
Route::post('/devstudios/create', 'DevelopmentStudioController@create')->middleware('auth:api');

// JOB OFFERS
Route::resource('job-offer', 'JobOfferController')->except([
    'store'
]);
Route::group(['middleware' => 'auth:api'], function () {
   Route::post('job-offer', 'JobOfferController@store');
   Route::post('job-offer/{id}/apply', 'JobOfferController@emailApply');
});
