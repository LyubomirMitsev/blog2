<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Events\UserSignUpEvent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Mail\VerifySignUpEmail;
use Carbon\Carbon;

class UnregisteredUser extends Model implements MustVerifyEmail
{
    use SoftDeletes, HasRoles;

    protected $fillable = [
        'email', 'email_verified_at'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserSignUpEvent::class,
    ];

    protected $guard_name = 'web';

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return $this->email_verified_at != null;
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        $this->email_verified_at = Carbon::now();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $email = $this->getEmailForVerification();

        Mail::to($email)->send(new VerifySignUpEmail(encrypt($email)));
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }
}
