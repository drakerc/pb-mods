<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ModificationDevelopmentStudio
 *
 * @mixin \Eloquent
 */
class ModificationDevelopmentStudio extends Model
{
    public function developmentStudio()
    {
        return $this->belongsToMany('App\DevelopmentStudio');
    }
}
