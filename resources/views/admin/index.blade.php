@extends('layouts.admin')

@section('title')
Dashboard
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                    @include('partials.flash-messages')
                    @include('partials.errors')

            </div>
        </div>
    </div>
</div>
@endsection