<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class QuestionFile extends Model
{
    protected $fillable = [
        'legal_question_id',
        'file_path',
        'original_name',
        'file_type',
        'mime_type',
        'file_size',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'order' => 'integer',
        ];
    }

    /**
     * Get the question that owns this file.
     */
    public function question()
    {
        return $this->belongsTo(LegalQuestion::class, 'legal_question_id');
    }

    /**
     * Get the file URL.
     */
    public function getFileUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Check if file is an image.
     */
    public function isImage(): bool
    {
        return $this->file_type === 'image';
    }

    /**
     * Check if file is a PDF.
     */
    public function isPdf(): bool
    {
        return $this->file_type === 'pdf' || $this->mime_type === 'application/pdf';
    }

    /**
     * Check if file is a document (Word, etc.).
     */
    public function isDocument(): bool
    {
        return $this->file_type === 'document';
    }

    /**
     * Get file size in human readable format.
     */
    public function getFileSizeHumanAttribute(): string
    {
        if (!$this->file_size) {
            return 'Bilinmiyor';
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
