<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoReel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description', 
        'embed_code',
        'video_file',
        'thumbnail',
        'is_active',
        'order'
    ];

    /**
     * Get the URL for the video file.
     *
     * @return string|null
     */
    public function getVideoUrlAttribute()
    {
        return $this->video_file 
            ? asset('videos/reels/' . $this->video_file) 
            : null;
    }

    /**
     * Get the URL for the video thumbnail.
     *
     * @return string|null
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail 
            ? asset('images/reels/thumbnails/' . $this->thumbnail) 
            : null;
    }
}
