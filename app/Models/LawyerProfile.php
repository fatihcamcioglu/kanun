<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LawyerProfile extends Model
{
    /** @use HasFactory<\Database\Factories\LawyerProfileFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specializations',
        'bio',
        'bar_number',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'specializations' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the lawyer profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
