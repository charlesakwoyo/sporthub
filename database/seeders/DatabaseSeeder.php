<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user first
        $this->call(AdminUserSeeder::class);

        // Create regular users
        \App\Models\User::factory(10)->create();

        // Create blog categories and posts
        $this->call(BlogCategorySeeder::class);
        $this->call(BlogSeeder::class);

        // Create event categories and events
        $this->call(EventCategorySeeder::class);
        $this->call(EventSeeder::class);

        // Create comments for blogs
        $this->call(CommentSeeder::class);
    }
}