<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $file_path
 * @property string $file_type
 * @property int $file_size
 * @property int $downloads
 * @property int $availability
 * @property int|null $uploader_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDownloads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUploaderId($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'files';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'downloads', 'availability', 'created_at', 'updated_at', 'uploader_id'
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
