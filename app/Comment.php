<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GrahamCampbell\Markdown\Facades\Markdown;

class Comment extends Model
{
    protected $fillable = ['comment', 'post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function markAsAnswer()
    {
        $this->post->pending = false;
        $this->post->answer_id = $this->id;

        $this->post->save();
    }

    public function getAnswerAttribute()
    {
        return $this->id === $this->post->answer_id;
    }

    public function getSafeHtmlCommentAttribute()
    {
        return Markdown::convertToHtml(e($this->comment));
    }
}
