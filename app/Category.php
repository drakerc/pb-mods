<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $subCount;

    protected $appends = ['subcategoriesCount'];

    protected $fillable = [
        'title', 'description', 'parent', 'image', 'game', 'thumbnail', 'background'
    ];

    /**
     * Fetches subcategories of a category.
     *
     * @return array
     */
    public function getSubcategories()
    {
        return Category::where(['parent' => $this->id, 'active' => true])->get();
    }

    public function getSubcategoriesCountAttribute()
    {
        return Category::where(['parent' => $this->id, 'active' => true])->count();
    }

    public function getModificationsInCategory()
    {
        $mods = Modification::where(['category_id' => $this->id, 'active' => true])->get();
        $mods->transform(function($mod) {
            $mod->size = $mod->getModificationSizeName();
            $mod->development_status = $mod->getModificationDevStatus();
            return $mod;
        });
        return $mods;
    }
}
