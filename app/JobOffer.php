<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    protected $fillable = [
        'development_studio_id',
        'title',
        'body',
        'email',
        'valid_until'
    ];

    public function getIsValidAttribute()
    {
        $now = Carbon::now();
        return $this->valid_until > $now;
    }

    public function developmentStudio()
    {
        return $this->belongsTo('App\DevelopmentStudio', 'development_studio_id');
    }

}
