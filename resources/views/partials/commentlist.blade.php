@foreach($post->comments as $comment)
    <li class="comment even thread-even depth-1">
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

@if(Auth::User())
    @foreach($post->unapproved_comments as $comment)
        @if($comment->user->id == Auth::User()->id)
            <li class="comment even thread-even depth-1">
                <article id="comment-{{ $comment->id }}" class="comment grayout">
                    <header class="comment-meta comment-author vcard">
                        <img src="/uploads/avatars/{{ $comment->user->avatar }}" class="author-image">                            
                        <cite>
                            <b class="fn">
                                {{ $comment->user->name }}
                            </b> 
                            <p class="author-time">
                                {{ date('F dS, Y-H:i', strtotime($comment->created_at)) }}
                            </p>
                        </cite> 
                                
                            <b>Has not been approved yet.</b>
                    </header><!-- .comment-meta -->
                    
                    <section class="comment-content comment">
                        {{ $comment->content }}
                    </section><!-- .comment-content -->
                </article><!-- #comment-## -->
            </li><!-- #comment-## -->
        @endif
    @endforeach
@endif