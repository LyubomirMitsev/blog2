@extends('layouts.admin')

@section('title')
Create Category
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            <form method="POST" enctype="multipart/form-data" action="{{ route('category.store') }}" id="category_form">
                @csrf
                
                <label for="name">Name: </label>
                <input type="text" name="name" placeholder="Enter name of Category" id="name" required value="{{ old('name') }}">
            
                <label for="description">Description: </label>
                <textarea name="description" placeholder="Description of category here" rows="4" id="description" required>{{ old('description') }}</textarea>
        
                <a class="btn btn-primary" href="{{ url()->previous() }}" type="button">Cancel</a>
                <button type="submit" class="btn btn-primary" id="submitBtn">Save Changes</button>
            </form>
        </div>
    </div>
</div>
@endsection