<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;

    protected $fillable = [
        'video_category_id',
        'title',
        'short_description',
        'cover_image_path',
        'vimeo_link',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Get the category for this video.
     */
    public function category()
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }

    /**
     * Get Vimeo video ID from URL.
     */
    public function getVimeoIdAttribute(): ?string
    {
        if (!$this->vimeo_link) {
            return null;
        }

        // Extract Vimeo ID from URL
        // Supports: https://vimeo.com/123456789 or https://player.vimeo.com/video/123456789
        preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $this->vimeo_link, $matches);
        return $matches[1] ?? null;
    }

    /**
     * Get embed URL for Vimeo.
     */
    public function getEmbedUrlAttribute(): ?string
    {
        $vimeoId = $this->vimeo_id;
        return $vimeoId ? "https://player.vimeo.com/video/{$vimeoId}" : null;
    }

    /**
     * Get cover image URL.
     */
    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image_path) {
            return null;
        }
        
        // Filament FileUpload stores relative path, so we need to use Storage::url()
        return Storage::disk('public')->url($this->cover_image_path);
    }
}
