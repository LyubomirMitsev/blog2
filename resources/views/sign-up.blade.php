@extends('layouts.blog')

@section('primary-content')
<article class="format-standard hentry">
    <header class="entry-header">
        <h1 class="entry-title">Sign up for notification via email whenever a new post is published</h1>
    </header>

    <form method="POST" action="{{ route('sign-up.store') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <input type="hidden" name="recaptcha" id="recaptcha">

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary" 
                class="g-recaptcha" 
                data-sitekey="6LdbawEVAAAAAONrcNbJRrIJPZ7fBa4YYM8sts5L" 
                data-callback='onSubmit' 
                data-action='submit'>
                    {{ __('Sign Up') }}
                </button>
            </div>
        </div>
    </form>
</article>
@endsection

@role('admin')
    @section('secondary-content')
            @include('partials.admin-sidebar')
    @endsection
@else
    @section('secondary-content')
            @include('partials.sidebar')
    @endsection
@endrole