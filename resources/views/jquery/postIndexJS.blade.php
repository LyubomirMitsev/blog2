<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" defer></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" defer></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" defer></script>

<script type="text/javascript">
    $(function () {
      
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('post.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'title', name: 'title'},
              {data: 'author', name: 'author'},
              {data: 'categories', name: 'categories'},
              {data: 'comments', name: 'comments'},
              {data: 'created_at', name: 'created_at'},
              {data: 'updated_at', name: 'updated_at'},
              {data: 'published_at', name: 'published_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
      
    });
</script>