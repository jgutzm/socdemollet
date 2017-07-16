<?php

use App\Category;
use App\Post;

class CreatePostsTest extends FeatureTestCase
{
    function test_a_user_create_a_post()
    {
        // Having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';
        $this->actingAs($user = $this->defaultUser());

        $category = factory(Category::class)->create();

        // When
        $this->visit(route('posts.create'))
          ->type($title, 'title')
          ->type($content, 'content')
          ->select($category->id, 'category_id')
          ->press('Publicar');

        // Then
        $this->seeInDatabase('posts', [
          'title' => $title,
          'content' => $content,
          'pending' => true,
          'user_id' => $user->id,
          'category_id' => $category->id,
        ]);

        $post = Post::orderBy('created_at', 'desc')->first();

        // Test the author is suscribed automatically to the post
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Test a user is redirected to the posts details after creating it.
        $this->seePageIs($post->url);
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
