<?php

namespace App\Http\Controllers;

use App\Post;

class SubscriptionController extends Controller
{
    public function subscribe(Post $post)
    {
        auth()->user()->subscriptions()->attach($post);

        return redirect($post->url);
    }
}
