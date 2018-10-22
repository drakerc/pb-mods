<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\DevelopmentStudio
 *
 * @mixin \Eloquent
 */
class DevelopmentStudio extends Model
{
    const SPECIALIZATION_GENERAL = 0;
    const SPECIALIZATION_MODS = 1;
    const SPECIALIZATION_GAMES = 2;

    public function authors()
    {
        return $this->belongsToMany('App\User');
    }

    public function games()
    {
        return $this->belongsToMany('App\Game');
    }

    public function modifications()
    {
        return $this->belongsToMany('App\Modification');
    }

    public function getSpecializationAttribute()
    {
        if ($this->specialization === 0) {
            return 'Ogólna';
        }
        if ($this->specizliation === 1) {
            return 'Modyfikacje';
        }
        if ($this->specialization === 2) {
            return 'Gry indie';
        }
        return 'Inna';
    }

    protected $fillable = [
        'title', 'name', 'address', 'description', 'website', 'email', 'commercial', 'specialization'
    ];

    protected $appends = ['specialization'];
}
