<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalCategory extends Model
{
    /** @use HasFactory<\Database\Factories\LegalCategoryFactory> */
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
     * Get the legal questions for this category.
     */
    public function legalQuestions()
    {
        return $this->hasMany(LegalQuestion::class, 'category_id');
    }
}
