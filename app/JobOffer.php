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
        'valid_until'
    ];

    public function isValid()
    {
        $now = Carbon::now();
        return $this->valid_until > $now;
    }

}
