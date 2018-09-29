<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Game
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $description
 * @property int|null $logo_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereLogoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    protected $fillable = [
        'title',
        'description',
        'logo_id'
    ];

    protected $with = [
        'logo',
        'categories'
    ];


    public function getModificationCategories()
    {
        return Category::where(['game' => $this->id, 'game_category' => false, 'parent' => null])->get();
    }

    public function categories() {
        return $this->hasMany('App\Category', 'game')->where(['game_category' => true]);
    }

    public function logo() {
        return $this->belongsTo('App\File', 'logo_id');
    }

    public function posts() {
        return $this->hasMany('App\Post', 'game_id', 'id');
    }

    public function getPosts($value) {
        return $value->posts();
    }
}
