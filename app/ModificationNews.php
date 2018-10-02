<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModificationNews extends Model
{
    public function modification()
    {
        return $this->belongsTo('App\Modification');
    }
}
