@extends('layouts.admin')

@section('title')
Edit Post
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            <form method="POST" enctype="multipart/form-data" action="{{ route('post.update', $post->slug) }}" id="post_form">
                @csrf
                @method('PATCH')

                <label for="title">Title:</label>
                <input tupe="text" name="title" id="post_name" required value="{{ $post->title }}">

                <label for="categories">Select Categories:</label>
                <div>
                    <select class="multiple" name="categories[]" multiple="multiple">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->categories->contains($category->id) ? 'selected' : ''}}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status">Status:</label>
                    <select name="status">
                        <option value="draft">Draft</option>
                        <option value="publish" {{ $post->published_at != null ? 'selected' : ''}}>Published</option>
                    </select>
                </div>
                
                <label for="content">Content:</label>
                <textarea class="form-control" name="content" id="summary-ckeditor">{!! $post->content !!}</textarea>

                <a class="btn btn-primary" href="{{ route('post.index') }}" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary" id="submitPost">Save Changes</button>
            </form>
        </div>
    </div>
</div>

@include('jquery.adminDashboardPostJS')
@endsection