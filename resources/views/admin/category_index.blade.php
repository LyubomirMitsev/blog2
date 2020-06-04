@extends('layouts.admin')

@section('title')
Categories
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            @if( $categories->count() > 0)
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Number of Posts</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <th>{{ $category->name }}</th>
                                <th>{{ $category->description }}</th>
                                <th>{{ $category->posts->count() }}</th>
                                <th>{{ date('M j, Y - H:i:s', strtotime($category->created_at)) }}</th>
                                <th>{{ date('M j, Y - H:i:s', strtotime($category->updated_at)) }}</th>
                                <th class="actions">
                                    <a class="btn btn-success" href="{{ route('category.edit', $category->id) }}" type="button">Edit</a>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#delete-category-{{ $category->id }}">Delete</button>
                                </th>
                            </tr>
                            @include('modals.deleteCategoryModal')
                        @endforeach
                    </tbody>
                </table>

                {{ $categories->links() }}
            @endif
        </div>
    </div>
</div>
@endsection