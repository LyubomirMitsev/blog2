@extends('layouts.blog')

@section('primary-content')
<article class="format-standard hentry" style="margin-left: 5px;">
    <span id="avatar">
        <img src="/uploads/avatars/{{ $user->avatar }}" id="profile_image">
    </span>
    <h1 style="font-size: 30px;">{{ $user->name }}</h1>
    <h2 style="font-size: 30px;">{{ $user->email }}</h2>
    <div style="margin: 10px 0;">
    <form enctype="multipart/form-data" action="{{ route('profile.avatar') }}" method="POST">
        @csrf
        <label>Update profile image</label><br>
        <input type="file" name="avatar" required/><br>
        <span id="image_submit"><input type="submit" class="button btn-primary" /></span>
    </form>
    </div>
    <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary" style="margin-top: 5px;">Edit Profile</a>
</article>
@endsection