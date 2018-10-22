<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ModificationRating
 *
 * @property int $id
 * @property string|null $title
 * @property int $modification_id
 * @property int $rating
 * @property int $rating_usability
 * @property int $rating_fun
 * @property int $rating_quality
 * @property string $description
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modification $modification
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereRatingFun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereRatingQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereRatingUsability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ModificationRating whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ModificationRating extends Model
{
    const USABILITY_NONUSABLE = 1;
    const USABILITY_BARELYUSABLE = 2;
    const USABILITY_USABLE = 3;
    const USABILITY_PRETTYUSABLE = 4;
    const USABILITY_VERYUSABLE = 5;

    const FUN_AWFUL = 1;
    const FUN_BAD = 2;
    const FUN_MEDIOCRE = 3;
    const FUN_GOOD = 4;
    const FUN_GREAT = 5;

    const QUALITY_AWFUL = 1;
    const QUALITY_BAD = 2;
    const QUALITY_MEDIOCRE = 3;
    const QUALITY_GOOD = 4;
    const QUALITY_EXCEPTIONAL = 5;

    public function modification()
    {
        return $this->belongsTo('App\Modification');
    }

    protected $fillable = [
        'title', 'rating', 'rating_usability', 'rating_fun', 'rating_quality', 'description'
    ];
}
