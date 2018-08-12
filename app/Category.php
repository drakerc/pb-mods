<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Fetches subcategories of a category.
     *
     * @param $category
     * @return array
     */
    public function getSubcategories()
    {
//        $category = $id === null ? $this : Category::where('id', $id)->one();
        $categories = [];
        $subCategories = Category::where('parent', $this->id)->get();

        foreach ($subCategories as $subCategory) {
            $categories[] = $subCategory;
        }
        return $categories;
    }
}
