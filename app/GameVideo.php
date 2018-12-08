<?php

namespace App;

use Alaouy\Youtube\Youtube;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GameVideo extends Model
{
    protected $fillable = [
      'title', 'url', 'game_id'
    ];

    protected $appends = [
        'youtube', 'poster'
    ];

    public function getYoutubeAttribute()
    {
        try {
            return Youtube::parseVIdFromURL($this->url);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());
            return null;
        }
    }

    public function getPosterAttribute() {
        $youtube_id = $this->getYoutubeAttribute();
        return "https://img.youtube.com/vi/" . $youtube_id . "/hqdefault.jpg";
    }
}
