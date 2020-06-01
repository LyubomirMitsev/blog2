@extends('layouts.app')

@section('content')
    <div id="page" class="hfeed site">
        <header id="masthead" class="site-header" role="banner">
            <hgroup>
                <h1 class="site-title">
                    <a href="{{ route('welcome') }}" rel="home">Lyubomir Mitsev's personal blog</a>
                </h1>
                <h2 class="site-description">Thank you for visiting my blog</h2>
            </hgroup>

            <nav id="site-navigation" class="main-navigation" role="navigation">
                <div class="nav-menu">
                    <ul>
                        <li class="{{ Request::url() == route('welcome') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('welcome') }}">Recent Posts</a></li>
                        <li class="{{ Request::url() == route('contact') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('contact') }}">Contact</a></li>
                        <li class="{{ Request::url() == route('rules') ? 'current_page_item' : 'page_item' }}"><a href="{{ route('rules') }}">Rules</a></li>
                    </ul>
                </div>
            </nav><!-- #site-navigation -->

        </header>

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
                        <ul id="recentcomments"><li class="recentcomments">
                            @foreach( $comments as $comment )
                                <li class="recentcomments">
                                    <span class="comment-author-link">{{ $comment->user->name }}</span>
                                    on 
                                    
                                    @role('admin')
                                    <a href="{{ route('post.show', $comment->post->slug) }}#comment-{{ $comment->id }}">
                                        {{ $comment->post->title }}
                                    </a> <!--link to the comment section in the post-->
                                    @else
                                    <a href="{{ route('post.view', $comment->post->slug) }}#comment-{{ $comment->id }}">
                                        {{ $comment->post->title }}
                                    </a> <!--link to the comment section in the post-->
                                    @endrole
                                </li>
                            @endforeach
                    </aside>		
                </div><!-- #secondary -->
        </div>
    </div>
@endsection