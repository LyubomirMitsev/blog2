@if( session('success') )
    <div class="alert alert-success" role="alert">
        <button type="button" class="close" data-dismiss="alert">X</button>
        {{ session('success') }}
    </div>
@endif