<?php

namespace App\Listeners;

use App\Events\CommentCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreateCommentEmail;

class SendCommentNotificationEmailListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentCreatedEvent  $event
     * @return void
     */
    public function handle(CommentCreatedEvent $event)
    {
        $comment = $event->comment;
        $post = $comment->post;
        $user = $post->user;

        Mail::to($user)->send(new UserCreateCommentEmail($comment));
    }
}
