<?php

class ShowPostTest extends FeatureTestCase
{
    function test_a_user_can_see_the_post_details()
    {
        // Having
        $user = $this->defaultUser([
            'username' => 'Jesús Gutiérrez'
        ]);

        $post = $this->createPost([
            'title' => 'Este es el título del post',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id,
        ]);
        
        // When
        $this->visit($post->url);

        // Then
        $this->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see('Jesús Gutiérrez');
    }

    function test_old_urls_are_redirected()
    {
        // Having
        $post = $this->createPost([
            'title' => 'Old title',
        ]);

        // When
        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url);

        // Then
        $this->seePageIs($post->url);
    }
}
