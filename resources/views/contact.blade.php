@extends('layouts.blog')

@section('primary-content')
    <article id="post-4" class="post-4 page type-page status-publish hentry">
        <header class="entry-header">
            <h1 class="entry-title">Contact</h1>
        </header>

        <div class="entry-content">
            <p>If you have any questions, you may ask me in the form below.</p>
            <h3><strong>I advise you to ask your questions as comprehendsable as possible so that I would be able to give precise answers.<br>
            </strong></h3>
            <p>I don't guarantee that I will be able to answer all questions!</p>
    
            <div role="form" class="wpcf7" id="wpcf7-f844-p4-o1" lang="en-US" dir="ltr">
                <div class="screen-reader-response"></div>
                    <form action="{{ route('contact.send') }}" method="post" class="wpcf7-form" novalidate="novalidate">
                        @csrf
                        <p>Your Name<br>
                            <span class="wpcf7-form-control-wrap your-name">
                                <input type="text" name="your-name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" aria-required="true" aria-invalid="false"></span> </p>
                        <p>Your Email<br>
                            <span class="wpcf7-form-control-wrap your-email">
                                <input type="email" name="your-email" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false"></span> </p>
                        <p>About<br>
                            <span class="wpcf7-form-control-wrap your-subject">
                                <input type="text" name="your-subject" value="" size="40" class="wpcf7-form-control wpcf7-text" aria-invalid="false"></span> </p>
                        <p>Your Message<br>
                            <span class="wpcf7-form-control-wrap your-message">
                                <textarea name="your-message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false"></textarea></span> </p>

                                <input type="hidden" name="recaptcha" id="recaptcha">

                        <p><input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit" 
                            class="g-recaptcha" 
                            data-sitekey="6LdbawEVAAAAAONrcNbJRrIJPZ7fBa4YYM8sts5L" 
                            data-callback='onSubmit' 
                            data-action='submit'><span class="ajax-loader"></span></p>
                        <div class="wpcf7-response-output wpcf7-display-none"></div>
                    </form>
                </div>
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