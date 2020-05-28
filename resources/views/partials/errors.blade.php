@if( $errors->any() )
    @foreach( $errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">X</button>
            {{ $error }}
        </div>
    @endforeach
@endif