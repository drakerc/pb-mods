<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModificationRating extends Model
{
    const USABILITY_NONUSABLE = 1;
    const USABILITY_BARELYUSABLE = 2;
    const USABILITY_USABLE = 3;
    const USABILITY_PRETTYUSABLE = 4;
    const USABILITY_VERYUSABLE = 5;

    const FUN_AWFUL = 1;
    const FUN_BAD = 2;
    const FUN_MEDIOCRE = 3;
    const FUN_GOOD = 4;
    const FUN_GREAT = 5;

    const QUALITY_AWFUL = 1;
    const QUALITY_BAD = 2;
    const QUALITY_MEDIOCRE = 3;
    const QUALITY_GOOD = 4;
    const QUALITY_EXCEPTIONAL = 5;

    public function modification()
    {
        return $this->belongsTo('App\Modification');
    }

    protected $fillable = [
        'title', 'rating', 'rating_usability', 'rating_fun', 'rating_quality', 'description'
    ];
}
