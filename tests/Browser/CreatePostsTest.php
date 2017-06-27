<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $title = 'Esta es una pregunta';
    protected $content = 'Este es el contenido';

    function test_a_user_create_a_post()
    {
        $user = $this->defaultUser();

        $this->browse(function ($browser) use ($user) {
            // Having
            $browser->loginAs($user)
                ->visitRoute('posts.create')
                ->type('title', $this->title)
                ->type('content', $this->content)
                ->press('Publicar')
                // Test a user is redirected to the posts details after creating it.
                ->assertPathIs('/posts/1-esta-es-una-pregunta');
        });

        // Then
        $this->assertDatabaseHas('posts', [
          'title' => $this->title,
          'content' => $this->content,
          'pending' => true,
          'user_id' => $user->id
        ]);

        $post = Post::first();

        // Test the author is suscribed automatically to the post
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

    }

    function test_creating_a_post_requires_authentication()
    {
        // When
        $this->visit(route('posts.create'));

        // Then
        $this->seePageIs(route('login'));
    }

    function test_create_post_form_validation()
    {
        // Having
        $this->actingAs($this->defaultUser());

        // When
        $this->visit(route('posts.create'))
          ->press('Publicar');

        // Then
        $this->seePageIs(route('posts.create'))
          ->seeErrors([
            'title' => 'El campo título es obligatorio',
            'content' => 'El campo contenido es obligatorio'
          ]);
    }
}
