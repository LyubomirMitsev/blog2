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

                <table class="table table-striped table-sm" id="all-categories">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Number of Posts</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>

                @include('modals.deleteCategoryModal')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

    $('#all-categories').DataTable({
        lengthMenu: [5, 10, 25],
        pageLength: 10,
        processing: true,
        bFilter: true,
        aaSorting: [0, 'asc'],
        serverSide: true,
        pagingType: 'simple_numbers',
        ajax: {
            url: '{{ route('get-all-categories') }}',
            type: "GET",
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'description'},
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    return row.posts.length;
                }
            },
            {data: 'created_at'},
            {data: 'updated_at'},
            {
                data: 'updated_at',
                render: function (data, type, row, meta) {
                    return handleEditButton(row);
                },
            },
            {   
                data: 'id',
                render: function (data, type, row, meta) {
                    return handleDeleteButton(row);
                },
            }
        ]
    });

    $('#all-categories').on('click', 'button.delete-category', function (event) {
        event.preventDefault();
        let id = $(this).data('id');

        let modal = $('#confirmDeleteCategoryModal');
        modal.modal('show');

        $('#confirmDeleteCategoryModal form').attr('action', '/category/' + id);
    });

    function handleEditButton(row) 
    {
        let output = '<a class="btn btn-success" href="/category/' + row.id + '/edit" type="button">Edit</a>';
        return output;
    }

    function handleDeleteButton(row) 
    {
        let output = '<button data-id="' + row.id + '" class="btn btn-danger delete-category">Delete</button>';
        return output;
    }

</script>

@endpush