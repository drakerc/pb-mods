<?php

namespace App;

use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ModificationVideo
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $title
 * @property int $modification_id
 * @property string $url
 * @property int $availability
 * @property int|null $uploader_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $youtube_id
 * @property-read \App\Modification $modification
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereUploaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationVideo whereUrl($value)
 */
class ModificationVideo extends Model
{
    public function modification()
    {
        return $this->belongsTo('App\Modification');
    }

    public function getYoutubeIdAttribute()
    {
        return Youtube::parseVidFromURL($this->url);
    }

    protected $appends = ['youtubeId'];

    protected $fillable = [
        'title', 'url', 'modification_id'
    ];
}
