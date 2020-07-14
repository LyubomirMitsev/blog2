@extends('layouts.admin')

@section('title')
Unapproved Comments
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('partials.flash-messages')
            @include('partials.errors')

            <table class="table table-striped table-sm" id="all-comments">
                <thead>
                    <tr>
                        <th>Author</th>
                        <th>Comment</th>
                        <th>In Response to</th>
                        <th>Submitted on</th>
                        <th>Approve</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>

            @include('modals.approveCommentModal')
            @include('modals.deleteCommentModal')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

    $('#all-comments').DataTable({
        lengthMenu: [5, 10, 25],
        pageLength: 10,
        processing: true,
        bFilter: true,
        aaSorting: [3, 'desc'],
        serverSide: true,
        pagingType: 'simple_numbers',
        ajax: {
            url: '{{ route('get-all-comments') }}',
            type: "GET",
        },
        columns: [
            {data: 'user.name'},
            {data: 'content'},
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    let output = '<a href="/post/' + row.post.slug + '#comment-' + row.id +'">' + row.post.title + '</a>';
                    return output;
                }    
            },
            {data: 'created_at'},
            {
                data: 'updated_at',
                render: function (data, type, row, meta) {
                    return handleApproveButton(row);
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

    $('#all-comments').on('click', 'button.approve-comment', function (event) {
        event.preventDefault();
        let id = $(this).data('id');

        let modal = $('#confirmApproveCommentModal');
        modal.modal('show');

        $('#confirmApproveCommentModal form').attr('action', '/comment/' + id);
    });

    $('#all-comments').on('click', 'button.delete-comment', function (event) {
        event.preventDefault();
        let id = $(this).data('id');

        let modal = $('#confirmDeleteCommentModal');
        modal.modal('show');

        $('#confirmDeleteCommentModal form').attr('action', '/comment/' + id);
    });

    function handleApproveButton(row) 
    {
        let output = '<button data-id="' + row.id + '" class="btn btn-success approve-comment">Approve</button>';
        return output;
    }

    function handleDeleteButton(row) 
    {
        let output = '<button data-id="' + row.id + '" class="btn btn-danger delete-comment">Delete</button>';
        return output;
    }

</script>

@endpush
