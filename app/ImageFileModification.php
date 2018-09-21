<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageFileModification extends Model
{
    const TYPE_BACKGROUND = 0;
    const TYPE_THUMBNAIL = 1;
    const TYPE_SPLASH = 2;
    const TYPE_GALLERY = 3;

    protected $table = 'image_file_modification';
}
