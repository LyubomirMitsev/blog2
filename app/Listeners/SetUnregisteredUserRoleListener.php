<?php

namespace App\Listeners;

use App\Events\UserSignUpEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Permission\Traits\HasRoles;

class SetUnregisteredUserRoleListener
{
    use HasRoles;
    
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
     * @param  UserSignUpEvent  $event
     * @return void
     */
    public function handle(UserSignUpEvent $event)
    {
        $event->user->assignRole('end-user');
    }
}
