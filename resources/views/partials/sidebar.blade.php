<ul id="recentcomments">
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
</ul>