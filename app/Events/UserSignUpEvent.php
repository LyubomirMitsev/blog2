<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\UnregisteredUser;

class UserSignUpEvent
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UnregisteredUser $user)
    {
        $this->user = $user;
    }
}
