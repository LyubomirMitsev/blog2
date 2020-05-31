@component('mail::message')
# Comment Submitted

A new comment has been published on the <strong>{{ $comment->post->title }}</strong> post  by the user 
<strong>{{ $comment->user->name }}</strong> with email <strong>{{ $comment->user->email }}</strong>.

@component('mail::panel')
<a href="{{ route('admin.dashboard') }}">Go to dashboard</a>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent