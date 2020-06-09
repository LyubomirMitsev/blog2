@component('mail::message')
# Hello!

Please click the button below to verify your email address.

@component('mail::button', ['url' => "http://blog2.test/?hashedEmail=" . $hashedEmail ])
Verify Email Address
@endcomponent

If you did not sign up for notifications, no further action is required.<br>
Regards,<br>
{{ config('app.name') }}
@endcomponent