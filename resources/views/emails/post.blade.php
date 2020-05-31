@component('mail::message')
# A new post was published

A new post called <strong>{{ $post->title }}</strong>
was recently published by <strong>{{ $post->user->name }}</strong>.

@component('mail::button', ['url' => "http://blog2.test/posts/$post->slug"])
View Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent