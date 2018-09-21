<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Modification
 *
 * @property integer $id
 * @property string $title
 * @property string description
 * @property integer $development_status
 * @property integer $size
 * @property string $replaces
 * @property string $version
 * @property integer $creator
 * @property string $release_date // TODO add casting to DateTimeImmutable
 * @property integer $game_id
 * @property integer $category_id
 * @property string $font_color
 * @property integer $development_studio
 * @property bool $use_game_background
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\File[] $files
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereCreator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereDevelopmentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereDevelopmentStudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereFontColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereReplaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereUseGameBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modification whereVersion($value)
 * @mixin \Eloquent
 */
class Modification extends Model
{
    const DEV_STATUS_STARTED = 0;
    const DEV_STATUS_INPROGRESS = 1;
    const DEV_STATUS_TESTING = 2;
    const DEV_STATUS_RELEASED = 3;
    const DEV_STATUS_HIATUS = 4;

    const SIZE_SMALL = 0;
    const SIZE_MEDIUM = 1;
    const SIZE_BIG = 2;

    public function files()
    {
        return $this->belongsToMany('App\File')->withPivot('title', 'description');
    }

    public function images()
    {
        return $this->belongsToMany('App\File', 'image_file_modification', 'modification_id', 'file_id')->withPivot('active', 'type');
    }

    public function getModificationSizeName()
    {
        if ($this->size === self::SIZE_SMALL) {
            return 'Niewielka, pojedyńcza modyfikacja';
        }
        if ($this->size === self::SIZE_MEDIUM) {
            return 'Średniej wielkości modyfikacja';
        }
        if ($this->size === self::SIZE_BIG) {
            return 'Duża, kompletna modyfikacja';
        }

        return 'Inna';
    }

    public function getModificationDevStatus()
    {
        if ($this->development_status === self::DEV_STATUS_STARTED) {
            return 'Nierozpoczęty';
        }
        if ($this->development_status === self::DEV_STATUS_INPROGRESS) {
            return 'W trakcie tworzenia';
        }
        if ($this->development_status === self::DEV_STATUS_TESTING) {
            return 'W trakcie testów';
        }
        if ($this->development_status === self::DEV_STATUS_RELEASED) {
            return 'Wydany';
        }
        if ($this->development_status === self::DEV_STATUS_HIATUS) {
            return 'Wstrzymany';
        }

        return 'Inny';
    }

    public function getFiles()
    {
        return ($this->files()->where('availability', true)->get())->toArray();
    }

    public function getImages()
    {
        $images = $this->images()->where('availability', true)->wherePivot('active', '=', true)->wherePivot('type', '=', ImageFileModification::TYPE_GALLERY)->get();
        // TODO: check if we can pass something to wherePivot as array instead of using 2x wherePivot
        return $images->toArray();
    }

    protected $fillable = [
        'title', 'description', 'development_status', 'size', 'replaces', 'version', 'release_date', 'font_color', 'development_studio', 'use_game_background'
    ];
}
