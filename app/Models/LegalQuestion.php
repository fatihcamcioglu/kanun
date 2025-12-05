<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\LegalQuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'category_id',
        'assigned_lawyer_id',
        'title',
        'question_body',
        'voice_path',
        'status',
        'asked_at',
        'answered_at',
        'lawyer_rating',
        'rated_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'asked_at' => 'datetime',
            'answered_at' => 'datetime',
            'rated_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    /**
     * Get the user that asked the question.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order for this question.
     */
    public function order()
    {
        return $this->belongsTo(CustomerPackageOrder::class, 'order_id');
    }

    /**
     * Get the category for this question.
     */
    public function category()
    {
        return $this->belongsTo(LegalCategory::class, 'category_id');
    }

    /**
     * Get the assigned lawyer for this question.
     */
    public function assignedLawyer()
    {
        return $this->belongsTo(User::class, 'assigned_lawyer_id');
    }

    /**
     * Get the messages for this question.
     */
    public function messages()
    {
        return $this->hasMany(LegalMessage::class);
    }

    /**
     * Get the files for this question.
     */
    public function files()
    {
        return $this->hasMany(QuestionFile::class, 'legal_question_id')->orderBy('order');
    }

    /**
     * Check if question is waiting for assignment.
     */
    public function isWaitingAssignment(): bool
    {
        return $this->status === 'waiting_assignment';
    }

    /**
     * Check if question is answered.
     */
    public function isAnswered(): bool
    {
        return $this->status === 'answered';
    }

    /**
     * Check if question is closed.
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }

    /**
     * Get all lawyer messages for this question.
     */
    public function lawyerMessages()
    {
        return $this->messages()->where('sender_role', 'LAWYER');
    }

    /**
     * Check if all lawyer messages are rated.
     */
    public function allMessagesRated(): bool
    {
        $lawyerMessages = $this->lawyerMessages()->get();
        
        if ($lawyerMessages->isEmpty()) {
            return false;
        }

        return $lawyerMessages->every(fn($message) => $message->isRated());
    }

    /**
     * Check if question is rated.
     */
    public function isRated(): bool
    {
        return !is_null($this->lawyer_rating);
    }
}
