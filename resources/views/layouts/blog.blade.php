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

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdbawEVAAAAAONrcNbJRrIJPZ7fBa4YYM8sts5L"></script>
 
    <style>
        #profile_image{
           height: 150px;
           float: left;
           border-radius: 50%;
           margin-right: 25px;
           margin-bottom: 10px;
       }

       #image_submit{
           margin-top: 5px;
       }

       .navbar-toggler{
           position: relative;
           padding-left: 50px;
       }
         
       .author-image{
           width: 50px;
           height: 50px;
           float: left;
           margin-right: 25px;
       }

       .comment-actions{
           margin-top: 20px;
       }

       .hidden{
           display: none;
       }  

       .sign-up{
           float: right;
           margin-top: 10px;
       }

       hgroup{
           width: 60%;
           display: inline-block;
       }

       .grayout {
            opacity: 0.6; /* Real browsers */
            filter: alpha(opacity = 60); /* MSIE */
        }
   </style>
</head>
<body>
    <div id="page" class="hfeed site">
        <header id="masthead" class="site-header" role="banner">
            <hgroup>
                <h1 class="site-title">
                    <a href="{{ route('welcome') }}" rel="home">Lyubomir Mitsev's personal blog</a>
                </h1>
                <h2 class="site-description">Thank you for visiting my blog</h2>
            </hgroup>

            <form role="sign-up" method="post" action="{{ route('sign-up.store') }}" class="sign-up">
                @csrf
                <div>
                    <label class="screen-reader-text" for="s">Sign up with email:</label>
                    <input type="text" value="{{ Request::get('email') }}" name="email">
                    <input type="submit" value="Sign Up">
                </div>
            </form>

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <div class="nav-menu">
                    <ul>
                        @role('admin')
                            <li><a class="page_item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @endrole
                        <li class="{{ Request::url() == route('welcome') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('welcome') }}">Recent Posts</a></li>
                        <li class="{{ Request::url() == route('contact') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('contact') }}">Contact</a></li>
                        <li class="{{ Request::url() == route('rules') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('rules') }}">Rules</a></li>

                        <span style="float: right;">
                            
                        @guest
                            @if (Route::has('register'))
                                <li class="{{ Request::url() == route('register') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @endif
                                <li class="{{ Request::url() == route('login') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        @else
                        <li class="page_item dropdown">
                                <a id="navbarDropdown" class="page_item dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show', Auth::user()->id ) }}">
                                        {{ __('Profile') }}
                                    </a>

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
                        </span>
                    </ul>
                </div>
            </nav><!-- #site-navigation -->

        </header>

        @include('partials.errors')

        @include('partials.flash-messages')

        <div id="main" class="wrapper">

            <div id="primary" class="site-content">
                <div id="content" role="main">
                    
                    @yield('primary-content')
                   
                </div><!-- #content -->
            </div><!-- #primary -->
        
        
                <div id="secondary" class="widget-area" role="complementary">
                    <aside id="search-3" class="widget widget_search">
                        <form role="search" method="get" id="searchform" class="searchform" action="{{ route('post.search') }}">
                            <div>
                                <label class="screen-reader-text" for="s">Search for:</label>
                                <input type="text" value="{{ Request::get('search') }}" name="search" id="s">
                                <input type="submit" id="searchsubmit" value="Search">
                            </div>
                        </form>
                    </aside>
                    <aside id="recent-comments-3" class="widget widget_recent_comments">
                        <h3 class="widget-title">Most Recent comments</h3> 

                        @yield('secondary-content')

                    </aside>		
                </div><!-- #secondary -->
        </div>
    </div>
</body>
</html>

<script>
    $('.entry-content a').attr('target', '_blank')
</script>

<script>
      grecaptcha.ready(function() {
        grecaptcha.execute('6LdbawEVAAAAAONrcNbJRrIJPZ7fBa4YYM8sts5L', {action: 'submit'}).then(function(token) {
            if (token) {
                document.getElementById('recaptcha').value = token;
            }
        });
      });
</script>

<script>
    (function () {
        let post = $('#post-title').attr('element');
        $('.commentlist').load('/comment-list/' + post);

        refresh();
    })();

    function refresh() {
        setTimeout(function () {
            let post = $('#post-title').attr('element');
            $('.commentlist').load('/comment-list/' + post);

            refresh();
        }, 10000);
    }
</script>

<script>
    (function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         $('#submit_comment_button').on('click', function(event) {
            event.preventDefault();

            $.ajax({
                url: "{{ route('comment.store') }}",
                method: 'POST',
                dataType: 'json',
                data: $('#commentform').serialize(),
                success: function(data) {

                    let date = new Date(data.created_at);
                    let minutes = date.getMinutes() > 9 ? date.getMinutes() : '0' + date.getMinutes();
                    let month = new Array();
                    month[0] = "January";
                    month[1] = "February";
                    month[2] = "March";
                    month[3] = "April";
                    month[4] = "May";
                    month[5] = "June";
                    month[6] = "July";
                    month[7] = "August";
                    month[8] = "September";
                    month[9] = "October";
                    month[10] = "November";
                    month[11] = "December";

                    $('<li class="comment even thread-even depth-1" ><article id="comment-' + data.id + '" class="comment grayout">'
                        + '<header class="comment-meta comment-author vcard">'
                        + '<img src="/uploads/avatars/' + data.user.avatar + '" class="author-image">'
                        + '<cite><b class="fn">'
                        + data.user.name
                        + '</b> <p class="author-time">'
                        + month[date.getMonth()] + ' ' + date.getDate() + 'th, ' +date.getFullYear() + '-' + date.getHours() + ":" + minutes 
                        + '</p></cite>'
                        + '<b>Has not been approved yet.</b>'
                        + '</header>'
                        + '<section class="comment-content comment">'
                        + data.content
                        + '</section>'
                        + '</article></li>')
                            .appendTo('ol.commentlist');

                    $('textarea[name="content"]').val(null);
                },
                error: function() {
                    
                    $('<li class="comment even thread-even depth-1" ><article id="comment-' + data.id + '" class="comment grayout">'
                        + '<section class="comment-content comment">'
                        + 'Sorry! An error occured and we could not post your comment.'
                        + '</section></article></li>')
                            .appendTo('ol.commentlist');
                }
            })
         });
    })();
</script>


