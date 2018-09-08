<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function getModificationCategories()
    {
        return Category::where(['game' => $this->id, 'game_category' => false, 'parent' => null])->get();
    }
}
