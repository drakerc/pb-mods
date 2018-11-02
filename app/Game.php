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

    public function developmentStudio()
    {
        return $this->belongsToMany('App\DevelopmentStudio');
    }

    public function getModificationCategories()
    {
        return Category::where(['game' => $this->id, 'game_category' => false, 'parent' => null])->paginate(10);
    }

    public function categories() {
        return $this->belongsToMany('App\Category', 'category_game');
    }

    public function logo() {
        return $this->belongsTo('App\File', 'logo_id');
    }

    public function posts() {
        return $this->hasMany('App\Post', 'game_id', 'id')->orderBy('created_at', 'desc');
    }

    public function getPosts($value) {
        return $value->posts();
    }

    public function files() {
        return $this->belongsToMany('App\File', 'file_game');
    }
}
