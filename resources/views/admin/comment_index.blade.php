@extends('layouts.admin')

@section('title')
Unapproved Comments
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            @if( $comments->count() > 0)
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Author</th>
                                <th>Comment</th>
                                <th>In Response to</th>
                                <th>Submitted on</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <th>{{ $comment->user->name }}</th>
                                    <th>{{ strlen($comment->content) > 50 ? substr($comment->content, 0, 50) . "..." : $comment->content }}</th>
                                    <th><a href="{{ route('post.show', $comment->post->slug) }}#comment-{{ $comment->id }}">{{ $comment->post->title }}</a></th>
                                    <th>{{ date('M j, Y - H:i:s', strtotime($comment->created_at)) }}</th>
                                    <th>
                                        <button class="btn btn-success" data-toggle="modal" data-target="#approve-comment-{{ $comment->id }}">Approve</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete-comment-{{ $comment->id }}">Delete</button>
                                    </th>
                                </tr>
                                @include('modals.approveCommentModal')
                                @include('modals.deleteCommentModal')
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{ $comments->links() }}
            @endif
        </div>
    </div>
</div>
@endsection