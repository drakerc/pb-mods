<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategoryApi(Category $category)
    {
        return $category->toJson();
    }
}
