<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPackageOrder extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerPackageOrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'status',
        'payment_method',
        'payment_status',
        'paid_at',
        'starts_at',
        'expires_at',
        'remaining_question_count',
        'remaining_voice_count',
        'bank_transfer_receipt_path',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'remaining_question_count' => 'integer',
            'remaining_voice_count' => 'integer',
        ];
    }

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the package for this order.
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the legal questions for this order.
     */
    public function legalQuestions()
    {
        return $this->hasMany(LegalQuestion::class, 'order_id');
    }

    /**
     * Check if order is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid' && $this->payment_status === 'success';
    }

    /**
     * Check if order is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
