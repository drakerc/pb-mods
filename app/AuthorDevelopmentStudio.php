<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AuthorDevelopmentStudio
 *
 * @mixin \Eloquent
 */
class AuthorDevelopmentStudio extends Model
{
    public function developmentStudio()
    {
        return $this->belongsToMany('App\DevelopmentStudio');
    }
}
