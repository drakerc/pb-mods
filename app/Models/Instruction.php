<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\Instruction
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $author_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instruction whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instruction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instruction whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instruction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Instruction extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'instructions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'title', 'description', 'created_at', 'updated_at', 'author_id'
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
