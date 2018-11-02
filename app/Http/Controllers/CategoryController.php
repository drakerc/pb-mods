<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private function prepareGameModsCategories(Game $game, Request $request)
    {
        $categories = $game->getModificationCategories();

        $categories->transform(function($cat) {
            $cat['background'] = asset(
                'storage/' . $cat['background']
            );
            $thumbnailFile = $cat['thumbnail'] === null ? 'no_photo.png' : $cat['thumbnail'];

            $cat['thumbnail'] = asset(
                'storage/' . $thumbnailFile
            );
            return $cat;
        });

        if ($request->ajax()) {
            return [
                'categories' => $categories->toArray(),
                'game' => $game->toArray(),
            ];
        }

        return [
            'categories' => $categories->toArray(),
            'game' => $game->toArray(),
            'path' => $request->getPathInfo(),
            'auth' => Auth::check()
        ];
    }

    private function prepareCategoryCreationInfo(Game $game, Category $category = null, Request $request)
    {
        if ($request->ajax()) {
            return [
                'category' => $category === null ? null : $category->toArray(),
                'game' => $game->toArray(),
                'auth' => Auth::check()
            ];
        }
        return [
            'category' => $category === null ? null : $category->toArray(),
            'game' => $game->toArray(),
            'path' => $request->getPathInfo(),
            'auth' => Auth::check()
        ];
    }

    private function setSubcategories(Category $category, Request $request)
    {
        $model = $category->toArray();
        $model['subcategories'] = $category->getSubcategories();
        $model['background'] = asset( // TODO: move to model as a appendable attribute
            'storage/' . $model['background']
        );
        $thumbnailFile = $model['thumbnail'] === null ? 'no_photo.png' : $model['thumbnail'];

        $model['thumbnail'] = asset(
            'storage/' . $thumbnailFile
        );

        if ($request->ajax()) {
            return ['category' => $model];
        }
        return [
            'path' => $request->getPathInfo(),
            'category' => $model
        ];
    }

    public function getGameModsCategories(Game $game, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->prepareGameModsCategories($game, $request));
        }
        return view('start', ['model' => $this->prepareGameModsCategories($game, $request)]);
    }

    public function getCategory(Game $game, Category $category, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->setSubcategories($category, $request));
        }
        return view('start', ['model' => $this->setSubcategories($category, $request)]);
    }

    public function getSubcategoriesApi(Category $category, Request $request)
    {
        return $category->getSubcategories(); // where the f is toarray?
    }

    public function createCategory(Game $game, Category $category = null, Request $request)
    {
        if ($request->ajax()) {
            return response()->json($this->prepareCategoryCreationInfo($game, $category, $request));
        }
        if ($request->method() === 'GET') {
            return view('start', ['model' => $this->prepareCategoryCreationInfo($game, $category, $request)]);
        }

        $category = new Category(
            [
                'title' => $request->title,
                'description' => $request->description,
            ]);

        $category->game_category = false;

        $category->parent = $request->categoryid !== '' ? (int)$request->categoryid : null;
        $category->author = Auth::id();
        $category->game = $request->gameid;
        $category->active = false; // TODO: true if admin

        if ($request->file('thumbnail') !== null) {
            $category->thumbnail = $request->file('thumbnail')->store('category_thumbnails', ['disk' => 'public']);
        }

        if ($request->file('background') !== null) {
            $category->background = $request->file('background')->store('category_backgrounds', ['disk' => 'public']);
        }

        $category->save();
        return redirect()->route('ModCategory', ['game' => $request->gameid, 'category' => $category->id]);
    }

    public function getCategoryTitleApi(Category $category)
    {
        return $category->title;
    }

    public function getGameCategories() {
        $categories = Category::where('game_category', '=', true)->get();
        return response()->json($categories);
    }
}
