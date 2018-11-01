<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\ModificationVideo
 *
 * @property int $id
 * @property string|null $title
 * @property int $modification_id
 * @property string $url
 * @property int $availability
 * @property int|null $uploader_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereUploaderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationVideo whereUrl($value)
 * @mixin \Eloquent
 */
class ModificationVideo extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'modification_videos';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title', 'url', 'availability', 'modification_id', 'uploader_id'];
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
