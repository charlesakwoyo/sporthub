<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Sports News', 'description' => 'Latest updates and breaking news from the world of sports'],
            ['name' => 'Fitness Tips', 'description' => 'Health and fitness advice, workout routines, and wellness tips'],
            ['name' => 'Nutrition Guide', 'description' => 'Diet plans and nutritional advice for athletes and fitness enthusiasts'],
            ['name' => 'Workout Routines', 'description' => 'Effective exercise programs for all fitness levels'],
            ['name' => 'Athlete Spotlights', 'description' => 'Profiles and interviews with professional athletes'],
            ['name' => 'Sports Science', 'description' => 'The latest research and developments in sports science'],
            ['name' => 'Injury Prevention', 'description' => 'Tips and techniques to prevent sports injuries'],
            ['name' => 'Sports Technology', 'description' => 'Innovations and gadgets in the world of sports'],
            ['name' => 'Team Sports', 'description' => 'Coverage and analysis of team sports'],
            ['name' => 'Individual Sports', 'description' => 'Coverage and analysis of individual sports']
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);
            
            // Check if category with this slug already exists
            if (!BlogCategory::where('slug', $slug)->exists()) {
                BlogCategory::create([
                    'name' => $category['name'],
                    'slug' => $slug,
                    'description' => $category['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Blog categories seeded successfully!');
    }
}