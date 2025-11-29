<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function ($blog) {
            //
        })->afterCreating(function ($blog) {
            //
        });
    }

    /**
     * Generate a fake image and return its path.
     */
    protected function generateFakeImage(): ?string
    {
        try {
            // Create a temporary file with random image content
            $imageUrl = 'https://picsum.photos/800/600?random=' . rand(1, 1000);
            $tempFile = tempnam(sys_get_temp_dir(), 'blog_');
            file_put_contents($tempFile, file_get_contents($imageUrl));
            
            // Generate a unique filename
            $filename = 'blog_images/' . uniqid() . '.jpg';
            
            // Store the file in the storage
            Storage::disk('public')->put($filename, file_get_contents($tempFile));
            
            // Clean up
            unlink($tempFile);
            
            return $filename;
        } catch (\Exception $e) {
            \Log::error('Failed to generate fake image: ' . $e->getMessage());
            return null;
        }
    }
    
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        $content = [];
        
        // Generate multiple paragraphs of content
        for ($i = 0; $i < 5; $i++) {
            $content[] = '<p>' . $this->faker->paragraph(rand(3, 8)) . '</p>';
            
            // Add a subheading every 2-3 paragraphs
            if ($i % 2 === 0) {
                $content[] = '<h3>' . $this->faker->sentence(4) . '</h3>';
            }
            
            // Add an image every 3 paragraphs
            if ($i % 3 === 0) {
                $content[] = '<img src="https://picsum.photos/800/400?random=' . rand(1, 1000) . '" alt="' . $this->faker->sentence(3) . '" class="img-fluid my-4">';
            }
        }
        
        $publishedAt = $this->faker->dateTimeBetween('-1 year', 'now');
        $hasFeaturedImage = $this->faker->boolean(80); // 80% chance of having a featured image
        
        return [
            'title' => $title,
            'featured_image' => $hasFeaturedImage ? $this->generateFakeImage() : null,
            'slug' => \Illuminate\Support\Str::slug($title),
            'excerpt' => $this->faker->paragraph(2),
            'content' => implode('\n', $content),
            'meta_description' => $this->faker->sentence(10),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
            'is_published' => $this->faker->boolean(80), // 80% chance of being published
            'published_at' => $publishedAt,
            'views' => $this->faker->numberBetween(0, 10000),
            'blog_category_id' => \App\Models\BlogCategory::inRandomOrder()->first()?->id ?? \App\Models\BlogCategory::factory(),
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id ?? \App\Models\User::factory(),
            'created_at' => $publishedAt,
            'updated_at' => $this->faker->dateTimeBetween($publishedAt, 'now'),
        ];
    }
}
