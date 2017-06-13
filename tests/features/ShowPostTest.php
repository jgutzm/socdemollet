<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowPostTest extends TestCase
{
    public function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'name' => 'Jeśus Gutiérrez'
        ]);

        $post = factory(\App\Post::class)->make([
            'title' => 'Este es el título del post',
            'content' => 'Este es el contenido del post'
        ]);
        
        $user->posts()->save($post);

        // When
        $this->visit(route('posts.show', $post));

        // Then
        $this->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($user->name);
    }
}
