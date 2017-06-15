<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WriteCommentTest extends FeatureTestCase
{
    function test_a_user_can_write_a_comment()
    {
        // Having
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
}
