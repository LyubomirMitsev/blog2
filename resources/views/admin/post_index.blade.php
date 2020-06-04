@extends('layouts.admin')

@section('title')
Posts
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            @if( $posts->count() > 0)
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Categories</th>
                            <th>Comments</th>
                            <th>Created at</th>
                            <th>Last Modified</th>
                            <th>Status</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <th><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></th>
                                <th>{{ $post->user->name }}</th>
                                <th>{{ $post->categories->count() }}</th>
                                <th><a href="{{ route('post.show', $post->slug) }}#comments">{{ $post->unapproved_comments->count() + $post->comments->count() }}</a></th>
                                <th>{{ date('M j, Y - H:i:s', strtotime($post->created_at)) }}</th>
                                <th>{{ date('M j, Y - H:i:s', strtotime($post->updated_at)) }}</th>
                                <th>{{ $post->published_at != null ? "Published" : "In Draft" }}</th>
                                <th class="actions">
                                    <a class="btn btn-success" href="{{ route('post.edit', $post->slug) }}" type="button">Edit</a>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete-post-{{ $post->slug }}">Delete</button>
                                </th>
                            </tr>
                            @include('modals.deletePostModal')
                        @endforeach
                    </tbody>
                </table>

                {{ $posts->links() }}
            @endif
        </div>
    </div>
</div>
@endsection