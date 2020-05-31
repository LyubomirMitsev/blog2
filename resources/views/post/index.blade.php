@extends('layouts.blog')

@section('primary-content')
    @if(isset($category))
        <header class="archive-header">
            <h1 class="archive-title">Archive of category: <span>{{ $category->name }}</span></h1>
        </header>
    @endif
    @if( Request::get('search') !== null )
        <header class="archive-header">
            <h1 class="archive-title">Results of search for: <span>{{ Request::get('search') }}</span></h1>
        </header>
    @endif

    @if( $posts->count() > 0)
        @foreach($posts as $post)
            <article id="post-{{ $post->id }}" class="post type-post status-publish format-standard hentry">
                <header class="entry-header">

                    <h1 class="entry-title"><a href="{{ route('post.view', $post->slug) }}">{{ $post->title }}</a></h1>
                    <div class="comments-link">
                        <a href="{{ route('post.view', $post->slug) }}#comments">{{ $post->comments()->count() }} comments</a> <!--link to comments-->				
                    </div>
                </header>

                <div class="entry-content">
                    @if( Request::get('search') )
                        {!! substr( strip_tags($post->content) , 0, 500 ) !!}{{ strlen( strip_tags( $post->content ) ) > 500 ? "..." : "" }}
                    @else
                        {!! $post->content !!}
                    @endif
                </div>

                <footer class="entry-meta">
                    Published in 
                        @foreach($post->categories as $category)
                        <a href="{{ route('post.from.category', $category->id) }}" rel="category">
                                {{ $category->name }}   <!--link to all posts of that category-->
                            </a>
                        @endforeach
                        on 
                        <a href="{{ route('post.view', $post->slug) }}" rel="bookmark">   <!--link to blog post-->
                            <time class="entry-date">{{ date('M j, Y', strtotime($post->published_at) ) }}</time>
                        </a><span class="by-author"> 								
                </footer>
            </article>
        @endforeach
    @else
        <article class="post type-post status-publish format-standard hentry">
            <header class="entry-header">
                <h1 class="entry-title">Nothing found</h1>
            </header>

            <div class="entry-content">
                Nothing matches your criteria. Please try again with different key words.
            </div>
        </article>
    @endif
@endsection