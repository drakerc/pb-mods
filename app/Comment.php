<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'author_id',
        'post_id',
//        'reply_id',
        'body'
    ];

//    public function replies()
//    {
//        return $this->belongsTo('App\Comment');
//    }
}
