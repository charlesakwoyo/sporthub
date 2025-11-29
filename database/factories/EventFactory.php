<?php

namespace Database\Factories;

use App\Models\EventCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 year');
        $endDate = (clone $startDate)->modify('+' . rand(1, 3) . ' days');
        $sportTypes = ['Football', 'Basketball', 'Tennis', 'Swimming', 'Running', 'Cycling', 'Yoga', 'Volleyball', 'Golf', 'Hiking'];
        $skillLevels = ['Beginner', 'Intermediate', 'Advanced', 'All Levels'];
        $equipment = ['None', 'Bring your own racket', 'Running shoes required', 'Yoga mat required', 'Swimsuit required'];
        $statuses = ['upcoming', 'ongoing', 'completed', 'cancelled'];

        $title = $this->faker->sentence(3);
        
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'description' => $this->faker->paragraphs(3, true),
            'sport_type' => $this->faker->randomElement($sportTypes),
            'start_datetime' => $startDate,
            'end_datetime' => $endDate,
            'location' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'max_participants' => $this->faker->numberBetween(5, 50),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'skill_level' => $this->faker->randomElement($skillLevels),
            'equipment_needed' => $this->faker->randomElement($equipment),
            'is_public' => $this->faker->boolean(90), // 90% chance of being public
            'status' => 'upcoming',
            'image' => null, // Will be set by the seeder
            'user_id' => User::factory(),
        ];
    }

    public function public()
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => true,
        ]);
    }

    public function private()
    {
        return $this->state(fn (array $attributes) => [
            'is_public' => false,
        ]);
    }

    public function upcoming()
    {
        return $this->state(fn (array $attributes) => [
            'start_datetime' => $this->faker->dateTimeBetween('+1 day', '+1 month'),
            'status' => 'upcoming',
        ]);
    }

    public function ongoing()
    {
        return $this->state(fn (array $attributes) => [
            'start_datetime' => now()->subHours(1),
            'end_datetime' => now()->addHours(2),
            'status' => 'ongoing',
        ]);
    }

    public function featured()
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}