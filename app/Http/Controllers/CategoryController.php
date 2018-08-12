<?php

namespace App\Http\Controllers;

use App\Category;

class CategoryController extends Controller
{
    private function setSubcategories(Category $category)
    {
        $model = $category->toArray();
        $model['subcategories'] = $category->getSubcategories();
        return $model;
    }

    public function getSubcategoriesApi(Category $category)
    {
        return $category->getSubcategories();
    }

    public function getCategoryApi(Category $category)
    {
        return response()->json($this->setSubcategories($category));
    }

    public function getCategoryWeb(Category $category)
    {
        return view('start', ['model' => $this->setSubcategories($category)]);
    }

    public function getCategoriesApi()
    {
        $results = [];
        foreach (Category::all() as $category) {
            $results[] = $this->setSubcategories($category);
        }
        return response()->json($results);
    }

    public function getCategoriesWeb()
    {
        $results = [];
        foreach (Category::all() as $category) {
            $results[] = $this->setSubcategories($category);
        }
        return view('start', ['model' => $results]);
    }

    public function getMainCategoriesApi()
    {
        $results = [];
        foreach (Category::where('parent', null)->get() as $category) {
            $results[] = $this->setSubcategories($category);
        }
        return response()->json($results);
    }

    public function getMainCategoriesWeb()
    {
        $results = [];
        foreach (Category::where('parent', null)->get() as $category) {
            $results[] = $this->setSubcategories($category);
        }
        return view('start', ['model' => $results]);
    }
}
