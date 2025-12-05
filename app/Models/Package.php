<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /** @use HasFactory<\Database\Factories\PackageFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'question_quota',
        'voice_quota',
        'validity_days',
        'price',
        'currency',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'question_quota' => 'integer',
            'voice_quota' => 'integer',
            'validity_days' => 'integer',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the orders for this package.
     */
    public function orders()
    {
        return $this->hasMany(CustomerPackageOrder::class);
    }
}
