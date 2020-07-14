@extends('layouts.blog')

@section('primary-content')
    <article id="post-{{ $post->id }}" class="post type-post status-publish format-standard hentry">
        <header class="entry-header">

        <h1 class="entry-title"><a href="{{ route('post.view', $post->slug) }}" id="post-title" element="{{ $post->slug }}" >{{ $post->title }}</a></h1>
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

    <div id="comments" class="comments-area">
	
        <h2 class="comments-title">
            {{ $post->comments()->count() }} thoughts on “<span>{{ $post->title }}</span>”		
        </h2>

        <ol class="commentlist">
            
        </ol><!-- .commentlist -->
    </div>

    @auth
        <div id="respond" class="comment-respond">
            <h3 id="reply-title" class="comment-reply-title">Your comment:</h3>
            <form action="{{ route('comment.store') }}" method="post" id="commentform" class="comment-form">
                @csrf

                <div class="hidden">
                    <label class="label">Post id:</label>
                    <input type="text" name="post_id" id="post_id" value="{{ $post->id }}" readonly />
                    <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" readonly />
                </div>

                <p class="comment-form-comment">
                    <textarea id="comment" name="content" placeholder="Write your comment here" cols="45" rows="8" maxlength="65525" required="required"></textarea>
                </p>

                <p class="form-submit">
                    <button type="submit" id="submit_comment_button" class="submit">Publish</button> 
                </p>
            </form>
        </div>
    @endauth
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