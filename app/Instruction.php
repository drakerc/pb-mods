<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Instruction
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Instruction whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Instruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Instruction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Instruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Instruction whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Instruction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Instruction extends Model
{
    public function files()
    {
        return $this->belongsToMany('App\File');
    }

    protected $fillable = [
        'title',
        'description',
    ];
}
