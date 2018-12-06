<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

/**
 * App\Models\Modification
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $development_status
 * @property int $size
 * @property string|null $replaces
 * @property string|null $version
 * @property int|null $creator
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $release_date
 * @property int|null $game_id
 * @property int|null $category_id
 * @property string|null $font_color
 * @property int|null $development_studio
 * @property int $active
 * @property string|null $font_color_splash_text
 * @property string|null $color_splash_background
 * @property float|null $transparency_splash_background
 * @property string|null $font_color_description
 * @property string|null $color_description_background
 * @property float|null $transparency_description_background
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereColorDescriptionBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereColorSplashBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereDevelopmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereDevelopmentStudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereFontColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereFontColorDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereFontColorSplashText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereReplaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereTransparencyDescriptionBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereTransparencySplashBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereUseGameBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Modification whereVersion($value)
 * @mixin \Eloquent
 */
class Modification extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'modifications';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'title', 'description', 'development_status', 'size', 'replaces', 'version',
        'creator', 'release_date', 'game_id', 'category_id', 'font_color', 'development_studio', 'active',
        'font_color_splash_text', 'color_splash_background', 'transparency_splash_background',
        'font_color_description', 'color_description_background', 'transparency_description_background'
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
