@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-md-offset-1">
                <img src="/uploads/avatars/{{ $user->avatar }}" id="profile_image">
                <h2>{{ $user->name }}</h2>
                <h5>{{ $user->email }}</h5>
                <form enctype="multipart/form-data" action="{{ route('profile.avatar') }}" method="POST">
                    @csrf
                    <div><label>Update profile image</label></div>
                    <div><input type="file" name="avatar" /><div>
                    <div id="image_submit"><input type="submit" class="button btn-primary" /></div>
                </form>
            </div>
        </div>
    </div>
@endsection