<?php

namespace App\Http\Controllers;

use App\Category;
use App\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
//'auth' => Auth::check()
    private function prepareGameModsCategories(Game $game, Request $request = null)
    {
        $categories = $game->getModificationCategories();
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

//    public function getCategoriesApi()
//    {
//        $results = [];
//        foreach (Category::all() as $category) {
//            $results[] = $this->setSubcategories($category);
//        }
//        return response()->json($results);
//    }
//
//    public function getCategoriesWeb()
//    {
//        $results = [];
//        foreach (Category::all() as $category) {
//            $results[] = $this->setSubcategories($category);
//        }
//        return view('start', ['model' => $results]);
//    }
//
//    public function getMainCategoriesApi()
//    {
//        $results = [];
//        foreach (Category::where('parent', null)->get() as $category) {
//            $results[] = $this->setSubcategories($category);
//        }
//        return response()->json($results);
//    }
//
//    public function getMainCategoriesWeb()
//    {
//        $results = [];
//        foreach (Category::where('parent', null)->get() as $category) {
//            $results[] = $this->setSubcategories($category);
//        }
//        return view('start', ['model' => $results]);
//    }
}
