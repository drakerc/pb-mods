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
        return Category::where('parent', $this->id)->get();
    }

    public function getSubcategoriesCountAttribute()
    {
        return Category::where('parent', $this->id)->count();
    }

    public function getModificationsInCategory()
    {
        $mods = Modification::where(['category_id' => $this->id])->get();
        $mods->transform(function($mod) {
            $mod->size = $mod->getModificationSizeName();
            $mod->development_status = $mod->getModificationDevStatus();
            return $mod;
        });
        return $mods;
    }
}
