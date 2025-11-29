<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'sport_type',
        'start_datetime',
        'end_datetime',
        'location',
        'latitude',
        'longitude',
        'max_participants',
        'price',
        'skill_level',
        'equipment_needed',
        'is_public',
        'status',
        'image',
        'user_id'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_public' => 'boolean',
        'price' => 'decimal:2',
        'max_participants' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the likes for the event.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(EventLike::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EventCategory::class, 'category_id');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * The users that are attending the event.
     */
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user')
            ->withPivot('status', 'ticket_count')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('start_datetime', '>', now());
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getRemainingSpotsAttribute()
    {
        return $this->capacity - $this->registrations()->count();
    }

    public function isFull()
    {
        return $this->remaining_spots <= 0;
    }
}