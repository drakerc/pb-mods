<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $subCount;

    protected $appends = ['subcategoriesCount'];
    /**
     * Fetches subcategories of a category.
     *
     * @return array
     */
    public function getSubcategories()
    {
        $categories = [];
        $subCategories = Category::where('parent', $this->id)->get();

        foreach ($subCategories as $subCategory) {
            $categories[] = $subCategory;
        }
        return $categories;
    }

    public function getSubcategoriesCountAttribute()
    {
        return Category::where('parent', $this->id)->count();
    }
}
