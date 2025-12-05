<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    /** @use HasFactory<\Database\Factories\NotificationLogFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel',
        'type',
        'status',
        'response',
    ];

    protected function casts(): array
    {
        return [
            'response' => 'array',
        ];
    }

    /**
     * Get the user that received the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
