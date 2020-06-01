<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
         #profile_image{
            height: 150px;
            float: left;
            border-radius: 50%;
            margin-right: 25px;
        }

        #image_submit{
            margin-top: 5px;
        }

        #nav_image{
            height: 32px;           
            top: 10px;
            border-radius: 50%;
        }

        .navbar-toggler{
            position: relative;
            padding-left: 50px;
        }

        #navbarDropdown{
            font-size: 120%;
        }

        .hidden{
            display: none;
        }
          
        .author-image{
            width: 50px;
            height: 50px;
            float: left;
        }

        #profile-description h1{
            padding: 10px, 0px;
            font-size: 30px;
        }

        #profile-description h2{
            margin-bottom: 10px;
            font-size: 30px;
        }

        .comment-actions{
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('welcome') }}">
                    Home
                </a>
                @role('admin')
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                @endrole
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('sign-up.create') }}">{{ __('Sign Up') }}</a>
                            <li>
                        @else
                        <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="/uploads/avatars/{{ Auth::user()->avatar }}" id="nav_image">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id ) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('profile-form').submit();">
                                        {{ __('Profile') }}
                                    </a>

                                    <form id="profile-form" action="{{ route('profile.show', Auth::user()->id ) }}" method="GET" style="display: none;">
                                    </form>

                                    <a class="dropdown-item" href="{{ route('profile.edit', Auth::user()->id ) }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('edit-profile-form').submit();">
                                        {{ __('Edit Profile info') }}
                                    </a>

                                    <form id="edit-profile-form" action="{{ route('profile.edit', Auth::user()->id ) }}" method="GET">
                                    </form>

                                    <button class="dropdown-item" class="btn btn-danger" role="button" data-toggle="modal" data-target="#delete-profile-{{ Auth::user()->id }}">
                                        {{ __('Delete Profile') }}
                                    </button>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @include('partials.errors')

        @include('partials.flash-messages')

        @if(Auth::user())
            @include('modals.deleteProfileModal')
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
