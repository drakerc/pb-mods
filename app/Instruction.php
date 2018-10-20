<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    public function files()
    {
        return $this->belongsToMany('App\Files');
    }

    protected $fillable = [
        'title',
        'description',
    ];
}
