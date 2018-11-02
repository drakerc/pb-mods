<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ImageFileModification
 *
 * @property int $file_id
 * @property int $modification_id
 * @property int $active
 * @property int $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageFileModification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageFileModification whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageFileModification whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ImageFileModification whereType($value)
 * @mixin \Eloquent
 */
class ImageFileModification extends Model
{
    const TYPE_BACKGROUND = 0;
    const TYPE_THUMBNAIL = 1;
    const TYPE_SPLASH = 2;
    const TYPE_GALLERY = 3;

    protected $table = 'image_file_modification';
}
