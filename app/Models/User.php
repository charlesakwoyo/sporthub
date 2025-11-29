<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Ticket;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'phone',
        'password',
        'profile_photo',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
    ];

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is an organizer
     */
    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }

    /**
     * Get the events created by the user.
     * Also defines the relationship for events the user is attending.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_user')
            ->withPivot('status', 'registration_date')
            ->withTimestamps();
    }

    /**
     * Get the blog posts created by the user.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * Get the tickets purchased by the user.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    /**
     * Get the user's notifications.
     */
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->orderBy('created_at', 'desc');
    }
}