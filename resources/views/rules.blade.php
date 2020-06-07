@extends('layouts.blog')

@section('primary-content')
    <article id="post-494" class="post-494 page type-page status-publish hentry">
        <header class="entry-header">
            <h1 class="entry-title">Rules</h1>
        </header>

        <div class="entry-content">
            <p>The rules are very straight forward. You can post comment so long as you:</p>
            <ul>
                <li>Write in english</li>
                <li>Make sure you stay on topic</li>
                <li>Respect other people's opinion</li>
                <li>No cynicism</li>
                <li>No connections to illegal content</li>
                <li>Questions are to be asked in the contant form</li>
                <li>In order to get notified via email whenever a new post is published you need
                    to  sign up for notifications in the <strong>sign up</strong>
                    button on the navigation above.
                </li>
            </ul>
            <h2 style="text-align: center;">Important! In order to write comments on a post you must have a registration and be logged in.</h2>
        </div><!-- .entry-content -->
        <footer class="entry-meta">
        </footer><!-- .entry-meta -->
    </article>
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