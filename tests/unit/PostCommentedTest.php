<?php

use App\Comment;
use App\Notifications\PostCommented;
use App\Post;
use App\User;
use Illuminate\Notifications\Messages\MailMessage;

class PostCommentedTest extends TestCase
{
    function test_it_builds_a_mail_message()
    {

    	$post = new Post([
    		'title' => 'Este es el título del post'
    	]);

    	$author = new User([
    		'name' => 'Jesús Gutiérrez'
    	]);

    	$comment = new Comment;
    	$comment->post = $post;
    	$comment->user = $author;

        $notification = new PostCommented($comment);

        $subscriber = new User();

        $message = $notification->toMail($subscriber);

		$this->assertInstanceOf(MailMessage::class, $message);

		//dd ($message);

		$this->assertSame(
			"Nuevo comentario en: $post->title",
			$message->subject
		);

		$this->assertSame(
			"$author->name escribió un comentario en: $post->title",
			$message->introLines[0]
		);

		$this->assertSame(
			$comment->post->url,
			$message->actionUrl
		);
    }
}
