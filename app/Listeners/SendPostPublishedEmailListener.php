<?php

namespace App\Listeners;

use App\Events\PostSavedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostPublishedEmail;

use App\UnregisteredUser;

class SendPostPublishedEmailListener
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
     * @param  PostSavedEvent  $event
     * @return void
     */
    public function handle(PostSavedEvent $event)
    {
        $post = $event->post;
        $published = $post->published_at;

        if($published != null) {

            $unregistered_users = UnregisteredUser::where('email_verified_at', '!=', null);

            Mail::to($unregistered_users)->send(new PostPublishedEmail($post));
        }
    }
}
