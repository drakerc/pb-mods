<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('category', 'CategoryCrudController');
    CRUD::resource('file', 'FileCrudController');
    CRUD::resource('instruction', 'InstructionCrudController');
    CRUD::resource('modification', 'ModificationCrudController');
    CRUD::resource('modificationnews', 'ModificationNewsCrudController');
    CRUD::resource('modificationrating', 'ModificationRatingCrudController');
    CRUD::resource('modificationvideo', 'ModificationVideoCrudController');
    CRUD::resource('developmentstudio', 'DevelopmentStudioCrudController');
    CRUD::resource('authordevelopmentstudio', 'AuthorDevelopmentStudioCrudController');
    CRUD::resource('gamedevelopmentstudio', 'GameDevelopmentStudioCrudController');
    CRUD::resource('moddevelopmentstudio', 'ModificationDevelopmentStudioCrudController');
}); // this should be the absolute last line of this file