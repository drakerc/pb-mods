<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FileModification
 *
 * @property int $file_id
 * @property int $modification_id
 * @property string $title
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileModification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileModification whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileModification whereModificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FileModification whereTitle($value)
 * @mixin \Eloquent
 */
class FileModification extends Model
{
    protected $table = 'file_modification';
}
