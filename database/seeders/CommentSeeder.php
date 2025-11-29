<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all published blogs
        $blogs = Blog::where('is_published', true)->get();
        $users = User::all();

        // Create 5-10 comments for each blog
        foreach ($blogs as $blog) {
            $commentCount = rand(5, 10);
            
            for ($i = 0; $i < $commentCount; $i++) {
                $comment = Comment::create([
                    'content' => $this->faker->paragraph,
                    'user_id' => $users->random()->id,
                    'blog_id' => $blog->id,
                    'parent_id' => null,
                ]);

                // 30% chance to create replies to this comment
                if (rand(1, 100) <= 30) {
                    $replyCount = rand(1, 3);
                    for ($j = 0; $j < $replyCount; $j++) {
                        Comment::create([
                            'content' => $this->faker->sentence,
                            'user_id' => $users->random()->id,
                            'blog_id' => $blog->id,
                            'parent_id' => $comment->id,
                        ]);
                    }
                }
            }
        }
    }
}
