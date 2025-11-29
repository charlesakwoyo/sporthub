<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->unique()->word;

        // Generate a random image URL for the category
        $imageUrl = 'https://picsum.photos/800/600?random=' . rand(1, 1000);
        
        return [
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'description' => $this->faker->sentence,
            'image' => $this->faker->boolean(80) ? $imageUrl : null, // 80% chance of having an image
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}