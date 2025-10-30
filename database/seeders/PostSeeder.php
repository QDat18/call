<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users->take(10) as $user) {
            Post::create([
                'user_id' => $user->user_id,
                'title' => 'Sample Post from ' . $user->first_name,
                'content' => 'This is a sample post content. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
                'post_type' => 'general',
                'status' => 'published',
                'published_at' => now(),
                'views_count' => rand(10, 500),
                'likes_count' => rand(0, 50),
                'comments_count' => rand(0, 20),
            ]);
        }
    }
}