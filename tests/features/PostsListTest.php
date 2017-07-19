<?php

use App\Category;
use App\Post;
use Carbon\Carbon;

class PostsListTest extends FeatureTestCase
{
    function test_a_user_can_see_the_posts_list_and_go_to_the_details()
    {
        // Having
        $post = $this->createPost([
            'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?'
        ]);

        // When
        $this->visit('/');

        // Then
        $this->seeInElement('h1', 'Posts')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url);
    }

    function test_a_user_can_see_posts_filtered_by_category()
    {
        // Having
        $laravel = factory(Category::class)->create([
            'name' => 'Laravel', 'slug' => 'laravel'
        ]);

        $vue = factory(Category::class)->create([
            'name' => 'Vue.js', 'slug' => 'vue-js'
        ]);

        $laravelPost = factory(Post::class)->create([
            'title' => 'Posts de Laravel',
            'category_id' => $laravel->id
        ]);

        $vuePost = factory(Post::class)->create([
            'title' => 'Posts de Vue.js',
            'category_id' => $vue->id
        ]);

        // When
        $this->visit('/');

        // Then
        $this->see($laravelPost->title)
            ->see($vuePost->title)
            ->within('.categories', function () {
                $this->click('Laravel');
            })
            ->seeInElement('h1', 'Posts de Laravel')
            ->see($laravelPost->title)
            ->dontSee($vuePost->title);
    }

    function test_a_usar_can_see_posts_filtered_by_status()
    {
        // Having
        $pendingPost = factory(Post::class)->create([
            'title' => 'Post pendiente',
            'pending' => true
        ]);

        $completedPost = factory(Post::class)->create([
            'title' => 'Post completado',
            'pending' => false
        ]);

        // When
        $this->visitRoute('posts.pending');

        // Then
        $this->see($pendingPost->title)
            ->dontSee($completedPost->title);

        // When
        $this->visitRoute('posts.completed');

        // Then
        $this->see($completedPost->title)
            ->dontSee($pendingPost->title);
    }

    function test_the_posts_are_paginated()
    {
        // Having
        $oldest = factory(Post::class)->create([
            'title' => 'Post más antiguo',
            'created_at' => Carbon::now()->subDays(100)
        ]);

        factory(Post::class)->times(15)->create([
            'created_at' => Carbon::now()->subDay()
        ]);

        $newest = factory(Post::class)->create([
            'title' => 'Post más reciente',
            'created_at' => Carbon::now()
        ]);

        // When
        $this->visit('/');

        // Then
        $this->see($newest->title)
            ->dontSee($oldest->title)
            ->click('8')
            ->see($oldest->title)
            ->dontSee($newest->title);

    }
}
