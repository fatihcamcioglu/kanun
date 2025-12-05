<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalMessage extends Model
{
    /** @use HasFactory<\Database\Factories\LegalMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'legal_question_id',
        'sender_id',
        'sender_role',
        'message_body',
        'voice_path',
        'attachment_path',
        'rating',
        'rated_at',
    ];

    /**
     * Get the legal question that owns the message.
     */
    public function legalQuestion()
    {
        return $this->belongsTo(LegalQuestion::class);
    }

    /**
     * Get the user that sent the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Check if message is from lawyer.
     */
    public function isFromLawyer(): bool
    {
        return $this->sender_role === 'LAWYER';
    }

    /**
     * Check if message is rated.
     */
    public function isRated(): bool
    {
        return !is_null($this->rating);
    }
}
