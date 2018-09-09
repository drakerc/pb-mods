<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'game_id',
        'title',
        'body',
        'post_category_id'
    ];
    public function files()
    {
        return $this->belongsToMany('App\File', 'posts_files', 'file_id', 'post_id');
    }
}