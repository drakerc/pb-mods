<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GameDevelopmentStudio
 *
 * @mixin \Eloquent
 */
class GameDevelopmentStudio extends Model
{
    public function developmentStudio()
    {
        return $this->belongsToMany('App\DevelopmentStudio');
    }
}
