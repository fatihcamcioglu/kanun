<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the lawyer profile for this user.
     */
    public function lawyerProfile()
    {
        return $this->hasOne(LawyerProfile::class);
    }

    /**
     * Get the orders for this user (if customer).
     */
    public function orders()
    {
        return $this->hasMany(CustomerPackageOrder::class);
    }

    /**
     * Get the legal questions for this user (if customer).
     */
    public function legalQuestions()
    {
        return $this->hasMany(LegalQuestion::class);
    }

    /**
     * Get the assigned legal questions for this user (if lawyer).
     */
    public function assignedLegalQuestions()
    {
        return $this->hasMany(LegalQuestion::class, 'assigned_lawyer_id');
    }

    /**
     * Get the legal messages sent by this user.
     */
    public function legalMessages()
    {
        return $this->hasMany(LegalMessage::class, 'sender_id');
    }

    /**
     * Get the notification logs for this user.
     */
    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    /**
     * Check if user is lawyer.
     */
    public function isLawyer(): bool
    {
        return $this->role === 'LAWYER';
    }

    /**
     * Check if user is customer.
     */
    public function isCustomer(): bool
    {
        return $this->role === 'CUSTOMER';
    }
}
