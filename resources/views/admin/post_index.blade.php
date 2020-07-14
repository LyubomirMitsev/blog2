@extends('layouts.admin')

@section('title')
Posts
@endsection

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            <table class="table table-striped table-sm" id="all-posts">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Categories</th>
                        <th>Comments</th>
                        <th>Published at</th>
                        <th>Created at</th>
                        <th>Last Modified</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>

            @include('modals.deletePostModal')
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    $('#all-posts').DataTable({
        lengthMenu: [5, 10, 25],
        pageLength: 10,
        processing: true,
        bFilter: true,
        aaSorting: [0, 'asc'],
        serverSide: true,
        pagingType: 'simple_numbers',
        ajax: {
            url: '{{ route('get-all-posts') }}',
            type: "GET",
        },
        columns: [
            {data: 'id'},
            {
                data: 'title',
                render: function (data, type, row, meta) {
                    return handlePostUrl(row);
                }    
            },
            {
                data: 'user.name',
                render: function (data, type, row, meta) {
                    return row.user.name;
                }
            },
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    return row.categories.length;
                }
            },
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    let output = '<a href="/post/' + row.slug + '#comments">' + row.comments.length + '</a>';
                    return output;
                }
            },
            {data: 'published_at'},
            {data: 'created_at'},
            {data: 'updated_at'},
            {
                data: 'updated_at',
                render: function (data, type, row, meta) {
                    console.log(row);
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

    $('#all-posts').on('click', 'button.delete-post', function (event) {
        event.preventDefault();
        let id = $(this).data('id');

        let modal = $('#confirmDeletePostModal');
        modal.modal('show');

        $('#confirmDeletePostModal form').attr('action', '/post/' + id);
    });

    function handlePostUrl(row)
    {
        let output = '<a href="/post/' + row.slug + '">' + row.title + '</a>';
        return output;
    }

    function handleEditButton(row) 
    {
        let output = '<a class="btn btn-success" href="/post/' + row.slug + '/edit" type="button">Edit</a>';
        return output;
    }

    function handleDeleteButton(row) 
    {
        let output = '<button data-id="' + row.slug + '" class="btn btn-danger delete-post">Delete</button>';
        return output;
    }

</script>

@endpush