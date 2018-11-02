<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $parent
 * @property integer $author
 * @property bool $game_category
 * @property integer $game
 * @property string $thumbnail
 * @property string $background
 * @property bool $active
 * @package App
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereGame($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereGameCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $deep_modifications_count
 * @property-read mixed $deep_subcategories_count
 */
class Category extends Model
{
    protected $appends = ['subcategoriesCount', 'deepSubcategoriesCount', 'deepModificationsCount'];

    protected $fillable = [
        'title', 'description', 'thumbnail', 'background'
    ];

    /**
     * Fetches subcategories of a category.
     *
     * @return array
     */
    public function getSubcategories()
    {
        return Category::where(['parent' => $this->id, 'active' => true])->paginate(10);
    }

    public function getSubcategoriesCountAttribute()
    {
        return Category::where(['parent' => $this->id, 'active' => true])->count();
    }

    public function getDeepSubcategoriesCountAttribute($parentId = null, $count = 0)
    {
        if ($parentId === null) {
            $parentId = $this->id;
        }
        $subcats = Category::where(['parent' => $parentId, 'active' => true])->get(); // probably need to fetch id only

        foreach ($subcats as $cat) {
            $count++;
            $count = $this->getDeepSubcategoriesCountAttribute($cat->id, $count);
        }
        return $count;
    }

    public function getDeepModificationsCountAttribute($parentId = null, $count = 0)
    {
        if ($parentId === null) {
            $parentId = $this->id;
        }
        $subcats = Category::where(['parent' => $parentId, 'active' => true])->get();

        foreach ($subcats as $cat) {
            $count += Modification::where(['category_id' => $cat->id, 'active' => true])->count();
            $count = $this->getDeepSubcategoriesCountAttribute($cat->id, $count);
        }
        return $count;
    }

    public function getModificationsInCategory()
    {
        $mods = Modification::where(['category_id' => $this->id, 'active' => true])->paginate(5);
        $mods->transform(function($mod) {
            $mod->size = $mod->getModificationSizeName();
            $mod->development_status = $mod->getModificationDevStatus();
            return $mod;
        });
        return $mods;
    }
}
