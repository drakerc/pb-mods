<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\ModificationRating
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereRatingFun($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereRatingQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereRatingUsability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationRating whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ModificationRating extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'modification_ratings';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title', 'rating', 'rating_usability', 'rating_fun',
        'rating_quality', 'description', 'author_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
