<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BlogSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create storage directory if it doesn't exist
        if (!Storage::disk('public')->exists('blog_images')) {
            Storage::disk('public')->makeDirectory('blog_images');
        }

        // Ensure we have some blog categories
        if (BlogCategory::count() === 0) {
            $this->call(BlogCategorySeeder::class);
        }

        // Ensure we have some users
        if (User::count() === 0) {
            // Create an admin user if none exists
            User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                    'phone' => '+1234567890',
                ]
            );
            
            // Create some regular users if we don't have enough
            $existingUsers = User::count();
            if ($existingUsers < 5) {
                User::factory(5 - $existingUsers)->create();
            }
        }

        // Create blog posts
        $count = Blog::count();
        $desiredCount = 20; // Number of blog posts we want to have
        
        if ($count < $desiredCount) {
            // Create only the number of posts needed to reach the desired count
            $needed = $desiredCount - $count;
            $users = User::all();
            $categories = BlogCategory::all();

            if ($users->isEmpty() || $categories->isEmpty()) {
                $this->command->error('Cannot create blog posts. Need at least one user and one category.');
                return;
            }

            for ($i = 0; $i < $needed; $i++) {
                $user = $users->random();
                $category = $categories->random();
                
                Blog::factory()->create([
                    'user_id' => $user->id,
                    'blog_category_id' => $category->id,
                    'is_published' => $this->faker->boolean(80), // 80% chance of being published
                    'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
            
            $this->command->info("Created $needed blog posts with featured images.");
        } else {
            $this->command->info('No new blog posts needed. Current count: ' . $count);
        }
        $this->command->info('Blog posts seeded successfully!');
    }
}
