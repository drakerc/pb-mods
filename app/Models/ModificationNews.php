<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\ModificationNews
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $modification_id
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModificationNews whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ModificationNews extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'modification_news';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['title', 'description', 'author_id',];
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
