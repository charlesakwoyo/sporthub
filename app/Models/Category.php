<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active'
    ];

    /**
     * Get the events for the category.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
