@component('mail::message')
You have a new message from <strong>{{ $data['your-name'] }}</strong> 
on <strong>{{ $data['your-subject'] }}</strong> with the following content: <br><br>

{{ $data['your-message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
