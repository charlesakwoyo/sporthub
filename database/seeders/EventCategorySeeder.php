<?php

namespace Database\Seeders;

use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Football Tournament',
                'description' => 'Competitive football matches and tournaments',
                'image' => 'football.jpg',
            ],
            [
                'name' => 'Basketball League',
                'description' => 'Professional and amateur basketball leagues',
                'image' => 'basketball.jpg',
            ],
            [
                'name' => 'Marathon',
                'description' => 'Long-distance running competitions',
                'image' => 'marathon.jpg',
            ],
            [
                'name' => 'Swimming Competition',
                'description' => 'Competitive swimming events',
                'image' => 'swimming.jpg',
            ],
            [
                'name' => 'Tennis Championship',
                'description' => 'Tennis tournaments and championships',
                'image' => 'tennis.jpg',
            ],
        ];

        foreach ($categories as $index => $category) {
            $slug = Str::slug($category['name']);
            
            // Check if category with this slug already exists
            if (!EventCategory::where('slug', $slug)->exists()) {
                EventCategory::create([
                    'name' => $category['name'],
                    'slug' => $slug,
                    'description' => $category['description'],
                    'image' => $category['image'],
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Event categories seeded successfully!');
    }
}