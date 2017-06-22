<?php

use Illuminate\Support\Facades\Notification;

class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
        // Having
        Notification::fake();

        $post = $this->createPost();

        $user = $this->defaultUser();
        
        $comentario = 'Un comentario';

        // When
        $this->actingAs($user)
            ->visit($post->url)
            ->type($comentario, 'comment')
            ->press('Publicar comentario');

        // Then
        $this->seeInDatabase('comments', [
            'comment' => $comentario,
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->seePageIs($post->url);
    }

    function test_create_comment_form_validation()
    {
        // Having
        $this->actingAs($this->defaultUser());

        // When
        $post = $this->createPost();

        $this->visit($post->url)
          ->press('Publicar comentario');

        // Then
        $this->seePageIs($post->url)
          ->seeErrors([
            'comment' => 'El campo comentario es obligatorio'
          ]);
    }
}
