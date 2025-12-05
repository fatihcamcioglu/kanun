<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    /** @use HasFactory<\Database\Factories\VideoCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the videos for this category.
     */
    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Get active videos for this category.
     */
    public function activeVideos()
    {
        return $this->hasMany(Video::class)->where('is_active', true)->orderBy('order', 'asc');
    }
}
