@extends('layouts.blog')

@section('primary-content')
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

    <div id="comments" class="comments-area">
	
        <h2 class="comments-title">
            {{ $post->comments()->count() }} thoughts on “<span>{{ $post->title }}</span>”		
        </h2>

        <ol class="commentlist">
            @foreach($post->comments as $comment)
                <li class="comment even thread-even depth-1" id="li-comment-287126">
                    <article id="comment-{{ $comment->id }}" class="comment">
                        <header class="comment-meta comment-author vcard">
                            <img src="/uploads/avatars/{{ $comment->user->avatar }}" class="author-image">                            <cite>
                             
                                <b class="fn">
                                    {{ $comment->user->name }}
                                </b> 
                                <p class="author-time">
                                    {{ date('F dS, Y-H:i', strtotime($comment->created_at)) }}
                                </p>    
                            		
                        </header><!-- .comment-meta -->

                        
                        <section class="comment-content comment">
                            {{ $comment->content }}
                        </section><!-- .comment-content -->
                    </article><!-- #comment-## -->
                </li><!-- #comment-## -->
            @endforeach
        </ol><!-- .commentlist -->
    </div>

    <div id="comments" class="comments-area">
        <h2 class="comments-title">
            {{ $post->unapproved_comments()->count() }} unapproved thoughts on “<span>{{ $post->title }}</span>”		
        </h2>

        <ol class="commentlist">
            @foreach($post->unapproved_comments as $comment)
                <li class="comment even thread-even depth-1" id="li-comment-287126">
                    <article id="comment-{{ $comment->id }}" class="comment">
                        <header class="comment-meta comment-author vcard">
                            <img src="/uploads/avatars/{{ $comment->user->avatar }}" class="author-image">                            <cite>
                            
                                <b class="fn">
                                    {{ $comment->user->name }}
                                </b> 
                                <p class="author-time">
                                    {{ date('F dS, Y-H:i', strtotime($comment->created_at)) }}
                                </p>    
                                    
                        </header><!-- .comment-meta -->

                        
                        <section class="comment-content comment">
                            {{ $comment->content }}
                        </section><!-- .comment-content -->

                        <section class="comment-actions">
                            <button class="btn btn-success" data-toggle="modal" data-target="#approve-comment-{{ $comment->id }}">Approve</button>
                            <button class="btn btn-danger" data-toggle="modal" data-target="#delete-comment-{{ $comment->id }}">Delete</button>
                        </section>
                    </article><!-- #comment-## -->
                </li><!-- #comment-## -->
                @include('modals.approveCommentFromShowPageModal')
                @include('modals.deleteCommentFromShowPageModal')
            @endforeach
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
                    <button type="submit" id="submit" class="submit">Publish</button> 
                </p>
            </form>
        </div>
    @endauth
@endsection