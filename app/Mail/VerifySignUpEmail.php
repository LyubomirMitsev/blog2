<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifySignUpEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $hashedEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($hashedEmail)
    {
        $this->hashedEmail = $hashedEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.verify-sign-up');
    }
}
