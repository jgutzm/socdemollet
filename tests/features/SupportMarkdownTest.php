<?php

class SupportMarkdownTest extends FeatureTestCase
{
    function test_the_post_content_support_markdown()
    {
        $importantText = 'Un texto muy importante';

        $post = $this->createPost([
            'content' => "La primera parte del texto post. **$importantText**. La última parte del texto"
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);
    }

    function test_the_code_in_the_post_is_escaped()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";

        $post = $this->createPost([
            'content' => "`$xssAttack`, Texto normal post."
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal post')
            ->seeText($xssAttack);
    }

    function test_post_xss_attack()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";

        $post = $this->createPost([
            'content' => "$xssAttack, Texto normal post."
        ]);

        // ->dump() prints html content
        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal post')
            ->seeText($xssAttack);
    }

    function test_post_xss_attack_with_html()
    {
        $xssAttack = "<img src='img.jpg'>";

        $post = $this->createPost([
            'content' => "$xssAttack, Texto normal post."
        ]);

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal post')
            ->seeText($xssAttack);
    }

    function test_the_comment_content_support_markdown()
    {
        $importantText = 'Un texto muy importante';
        $comentario = "La primera parte del texto. **$importantText**. La última parte del texto";

        $post = $this->createPost();

        $this->actingAs($this->defaultUser())
            ->visit($post->url)
            ->type($comentario, 'comment')
            ->press('Publicar comentario');

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);
    }
    

    function test_the_code_in_the_comment_is_escaped()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";
        $comentario = "`$xssAttack`, Texto normal comentario.";

        $post = $this->createPost();

        $this->actingAs($this->defaultUser())
            ->visit($post->url)
            ->type($comentario, 'comment')
            ->press('Publicar comentario');
        
        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal comentario')
            ->seeText($xssAttack);
    }

    function test_comment_xss_attack()
    {
        $xssAttack = "<script>alert('Malicious JS!')</script>";
        $comentario = "$xssAttack, Texto normal comentario.";

        $post = $this->createPost();

        $this->actingAs($this->defaultUser())
            ->visit($post->url)
            ->type($comentario, 'comment')
            ->press('Publicar comentario');

        // ->dump() prints html content
        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal comentario')
            ->seeText($xssAttack);
    }

    function test_comment_xss_attack_with_html()
    {
        $xssAttack = "<img src='img.jpg'>";
        $comentario = "$xssAttack, Texto normal comentario.";

        $post = $this->createPost();

        $this->actingAs($this->defaultUser())
            ->visit($post->url)
            ->type($comentario, 'comment')
            ->press('Publicar comentario');

        $this->visit($post->url)
            ->dontSee($xssAttack)
            ->seeText('Texto normal comentario')
            ->seeText($xssAttack);
    }
}
