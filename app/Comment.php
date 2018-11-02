<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property int $id
 * @property int $author_id
 * @property int $post_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    //
    protected $fillable = [
        'author_id',
        'post_id',
        'body'
    ];

    protected $with = ['author'];
    protected $hidden = ['author_id'];


    public function author() {
        return $this-> belongsTo('App\User', 'author_id');
    }

}
