@if( session('success') )
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">X</button>
        {{ session('success') }}
    </div>
@endif

@if( session('error') )
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">X</button>
        {{ session('error') }}
    </div>
@endif