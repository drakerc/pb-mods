<?php

namespace App;

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

    protected $fillable = [
        'title', 'url', 'modification_id'
    ];
}
