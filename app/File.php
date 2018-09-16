<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function modifications()
    {
        return $this->belongsToMany('App\Modification')->withPivot('title', 'description');
    }
}
