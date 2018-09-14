<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    private function prepareGameModsCategories(Game $game, Request $request = null)
    {
        $categories = $game->getModificationCategories();

        $categories->transform(function($cat) {
            $cat['background'] = asset(
                'storage/' . $cat['background']
            );
            $cat['thumbnail'] = asset(
                'storage/' . $cat['thumbnail']
            );
            return $cat;
        });

        if ($request !== null) {
            return [
                'categories' => $categories->toArray(),
                'game' => $game->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ];
        }
        return [
            'categories' => $categories->toArray(),
            'game' => $game->toArray(),
        ];
    }

    private function prepareCategoryCreationInfo(Game $game, Category $category = null, Request $request = null)
    {
        if ($request !== null) {
            return [
                'category' => $category === null ? null : $category->toArray(),
                'game' => $game->toArray(),
                'path' => $request->getPathInfo(),
                'auth' => Auth::check()
            ];
        }
        return [
            'category' => $category === null ? null : $category->toArray(),
            'game' => $game->toArray(),
            'auth' => Auth::check()
        ];
    }

    public function getGameModsCategoriesApi(Game $game)
    {
        return response()->json($this->prepareGameModsCategories($game));
    }

    public function getGameModsCategoriesWeb(Game $game, Request $request)
    {
        return view('start', ['model' => $this->prepareGameModsCategories($game, $request)]);
    }

    private function setSubcategories(Category $category, Request $request = null)
    {
        $model = $category->toArray();
        $model['subcategories'] = $category->getSubcategories();
        $model['background'] = asset(
            'storage/' . $model['background']
        );
        $model['thumbnail'] = asset(
            'storage/' . $model['thumbnail']
        );

        if ($request !== null) {
            return [
                'path' => $request->getPathInfo(),
                'category' => $model
            ];
        }
        return ['category' => $model];
    }

    public function getCategoryApi(Game $game, Category $category)
    {
        return response()->json($this->setSubcategories($category));
    }

    public function getCategoryWeb(Game $game, Category $category)
    {
        return view('start', ['model' => $this->setSubcategories($category)]);
    }

    public function getSubcategoriesApi(Category $category)
    {
        return $category->getSubcategories();
    }

    public function getCategoryCreateApi(Game $game, Category $category = null)
    {
        return response()->json($this->prepareCategoryCreationInfo($game, $category));
    }

    public function getCategoryCreateWeb(Game $game, Category $category = null, Request $request)
    {
        return view('start', ['model' => $this->prepareCategoryCreationInfo($game, $category, $request)]);
    }

    public function createCategoryWeb(Request $request)
    {
        $category = new Category(
            [
                'title' => $request->title,
                'description' => $request->description,
                'game_category' => false,
                'parent' => $request->categoryid !== '' ? (int)$request->category : null,
                'author' => Auth::id(),
                'game' => $request->gameid,
                'active' => false // TODO: true if admin
            ]);

        if ($request->file('thumbnail') !== null) {
            $category->thumbnail = $request->file('thumbnail')->store('category_thumbnails', ['disk' => 'public']);
        }

        if ($request->file('background') !== null) {
            $category->background = $request->file('thumbnail')->store('category_backgrounds', ['disk' => 'public']);
        }

        $category->save();
        return redirect()->route('ModCategory', ['game' => $request->gameid, 'category' => $category->id]);
    }
}
