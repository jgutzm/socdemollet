<?php

use App\Notifications\PostCommented;
use App\User;
use Illuminate\Support\Facades\Notification;

class NotifyUsersTest extends FeatureTestCase
{
    function test_the_subscribers_receive_a_notification_when_post_is_commented()
    {
        // Having
        Notification::fake();

        $post = $this->createPost();

        $subscriber = $this->anyone();

        $subscriber->subscribeTo($post);

        $writer = $this->anyone();

        $comment = $writer->comment($post, 'Un comentario cualquiera');

        Notification::assertSentTo(
            $subscriber,
            PostCommented::class, function ($notification) use ($comment) {
                return $notification->comment->id == $comment->id;
            }
        );

        // The author of the comment shouldn't be notified even if he or she is a subscriber.
        Notification::assertNotSentTo($writer, PostCommented::class);
    }
}
