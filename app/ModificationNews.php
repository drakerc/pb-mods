<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ModificationNews
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $modification_id
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modification $modification
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationNews whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ModificationNews extends Model
{
    public function modification()
    {
        return $this->belongsTo('App\Modification');
    }

    public function getCreatorNameAttribute()
    {
        $creator = User::find($this->author_id);
        if ($creator === null) {
            return 'Nieznany';
        }
        return $creator->name;
    }

    protected $fillable = [
        'title',
        'description',
    ];

    protected $appends = ['creatorName'];
}
