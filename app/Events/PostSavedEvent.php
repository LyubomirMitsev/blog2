<?php

namespace App\Events;

use App\Post;
use Illuminate\Queue\SerializesModels;

class PostSavedEvent
{
    use SerializesModels;

    public $post;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
