<script type="text/javascript" src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script>
    CKEDITOR.replace( 'summary-ckeditor', {
        filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>

<script>
    ( function () {
        $('.checkbox-list-button').on('click', function () {
            $('#checkbox-list').empty();

            var postId = $('#post_id').val();
            var categoriesId = [];

            if( postId != null){
                $.get("{{ route('post.index') }}" + '/' + postId + "/edit", function(data) {
                    var categories = data['categories'];
                    
                    for(var i = 0; i < categories.length; i++){
                        categoriesId [i] = categories[i]['id'];
                    }
                });
            }

            $.get("{{ route('category.index') }}", function (data) {
                var length = data.length;

                for(var i = 0; i < length; i++) {

                    var current_checkbox = $('<div><input type="checkbox" value="' + data[i]['id'] + '" name="categories[]"><label>' + data[i]['name'] + '</label></div>');
                    
                    $('#checkbox-list').append(current_checkbox);

                    for(var j = 0; j < categoriesId.length; j++) {
                        if( $('input[type="checkbox"]').last().val() == categoriesId [j]) {
                            $('input[type="checkbox"]').last().click();
                        }
                    }
                }

            });

            if( $('#checkbox-list').attr('hidden') == 'hidden' ) {
                $('#checkbox-list').removeAttr('hidden');
                $('.checkbox-list-button').attr('area-expanded', true);
            }else{
                $('#checkbox-list').attr('hidden', true);
                $('.checkbox-list-button').attr('area-expanded', false);
            }
        });
        
    })();
</script>