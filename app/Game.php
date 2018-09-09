<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'description',
        'logo_id'
    ];

    public function getModificationCategories()
    {
        return Category::where(['game' => $this->id, 'game_category' => false, 'parent' => null])->get();
    }

    public function posts() {
        return $this->hasMany('App\Post');
    }
}
