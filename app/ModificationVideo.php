<?php

namespace App;

use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ModificationVideo
 *
 * @mixin \Eloquent
 */
class ModificationVideo extends Model
{
    public function modification()
    {
        return $this->belongsTo('App\Modification');
    }

    public function getYoutubeIdAttribute()
    {
        return Youtube::parseVidFromURL($this->url);
    }

    protected $appends = ['youtubeId'];

    protected $fillable = [
        'title', 'url', 'modification_id'
    ];
}
