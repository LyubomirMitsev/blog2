<?php

namespace App\Events;

use App\Comment;
use Illuminate\Queue\SerializesModels;

class CommentCreatedEvent
{
    use SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
