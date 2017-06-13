<?php

class CreatePostsTest extends FeatureTestCase
{
    function test_a_user_create_a_post()
    {
        // Having
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';
        $this->actingAs($user = $this->defaultUser());

        // When
        $this->visit(route('posts.create'))
          ->type($title, 'title')
          ->type($content, 'content')
          ->press('Publicar');

        // Then
        $this->seeInDatabase('posts', [
          'title' => $title,
          'content' => $content,
          'pending' => true,
          'user_id' => $user->id
        ]);

        // Test a user is redirected to the posts details after creating it.
        $this->see($title);
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
        $title_message = 'El campo título es obligatorio';
        $content_message = 'El campo contenido es obligatorio';
        $this->actingAs($this->defaultUser());

        // When
        $this->visit(route('posts.create'))
          ->press('Publicar');

        // Then
        $this->seePageIs(route('posts.create'))
          ->seeInElement('#field_title.has-error .help-block', $title_message)
          ->seeInElement('#field_content.has-error .help-block', $content_message);
    }
}
