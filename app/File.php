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
 * @property-read mixed $download_link
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Instruction[] $instructions
 */
class File extends Model
{

    protected $appends = ['downloadLink'];

    protected $fillable = ['file_path'];

    public function modifications()
    {
        return $this->belongsToMany('App\Modification')->withPivot('title', 'description');
    }

    public function instructions()
    {
        return $this->belongsToMany('App\Instruction');
    }

    public function getDownloadLinkAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    public function getHumanReadableFilesizeAttribute($decimals = 1)
    {
        if ($this->file_size == 0)
            return "0.00 B";

        $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        $e = floor(log($this->file_size, 1024));

        return round($this->file_size/pow(1024, $e), 2).$s[$e];
    }

    public function getCreatorNameAttribute()
    {
        $creator = User::find($this->uploader_id);
        if ($creator === null) {
            return 'Nieznany';
        }
        return $creator->name;
    }

}
