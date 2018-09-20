<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\File
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modification[] $modifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereDownloads($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\File whereUploaderId($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    protected $appends = ['downloadLink'];

    public function modifications()
    {
        return $this->belongsToMany('App\Modification')->withPivot('title', 'description');
    }

    public function getDownloadLinkAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
