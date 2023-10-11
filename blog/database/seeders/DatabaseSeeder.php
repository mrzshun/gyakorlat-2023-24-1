<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = \App\Models\User::factory(10)->create();
        $categories = \App\Models\Category::factory(10)->create();
        $posts = \App\Models\Post::factory(10)->create();
        $comments = \App\Models\Comment::factory(10)->create();
        foreach($posts as $post) {
            if(rand(1,10)>5) {
                $post->author()->associate(\App\Models\User::all()->random())->save();
            }
            $post->categories()->sync(
                $categories->random(
                    rand(1,$categories->count())
                )
            );
        }
    }
}
