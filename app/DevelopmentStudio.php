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

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_development_studio');
    }

    public function games()
    {
        return $this->belongsToMany('App\Game', 'game_development_studio');
    }

    public function modifications()
    {
        return $this->belongsToMany('App\Modification', 'modification_development_studio');
    }

    public function jobOffers()
    {
        return $this->hasMany('App\JobOffer', 'development_studio_id');
    }

    public function getSpecializationTextAttribute()
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

    public function getOwnerNameAttribute()
    {
        $creator = User::find($this->uploader_id);
        if ($creator === null) {
            return 'Nieznany';
        }
        return $creator->name;
    }

    protected $fillable = [
        'title', 'name', 'address', 'description', 'website', 'email', 'commercial', 'specialization'
    ];

    protected $appends = ['specializationText', 'ownerName'];
}
