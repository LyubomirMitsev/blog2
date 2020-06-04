@extends('layouts.blog')

@section('primary-content')   
    @foreach($posts as $post)
        <article id="post-{{ $post->id }}" class="post type-post status-publish format-standard hentry">
            <header class="entry-header">
    
                <h1 class="entry-title"><a href="{{ route('post.view', $post->slug) }}">{{ $post->title }}</a></h1>
                <div class="comments-link">
                    <a href="{{ route('post.view', $post->slug) }}#comments">{{ $post->comments()->count() }} comments</a> <!--link to comments-->				
                </div>
            </header>

            <div class="entry-content">
                {!! $post->content !!}
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

    {{ $posts->links() }}
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