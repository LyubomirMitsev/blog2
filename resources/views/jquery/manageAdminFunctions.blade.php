<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

<script>
    (function (){

        var start = 0;
        var elements_per_page = 5;

        var managePostsCategoriesComments = {
            category_form: $('#category_form'),

            category_table: $('#category_table'),

            category_tbody: $('#category_tbody'),

            post_form: $('#post_form'),

            post_table: $('#post_table'),

            post_tbody: $('#post_tbody'),

            comment_table: $('#comment_table'),

            comment_tbody: $('#comment_tbody'),

            view_comment: $('#view_comment'),

            init: function() {

                $('#index_category')
                  .on('click', function () {
                      start = 0;
                      managePostsCategoriesComments.show_all();
                  });

                $('a#new_category')
                  .on('click', managePostsCategoriesComments.show_create);

                $('a#index_post')
                  .on('click', function () {
                      start = 0;
                      managePostsCategoriesComments.show_all_posts();
                  });

                $('a#new_post')
                  .on('click', managePostsCategoriesComments.show_create_post);

                $('a#index_comment')
                  .on('click', function () {
                      start = 0;
                      managePostsCategoriesComments.show_all_comments();
                  });

                $('.nextValue').on('click', function () {

                    var next = $('a.checked')
                                .next()
                                .attr('number');
                    
                    $('a[number="' + next + '"]').click();
                });

                $('.preValue').on('click', function () {

                    var prev = ($('a.checked').attr('number') - 1);
                    
                    $('a[number="' + prev + '"]').click();
                });

                $('#approveBtn').on('click', function (e) {
                    e.preventDefault();
                    $('#approveCommentModal').modal('hide');

                    $.ajax({
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        url: $('#approveCommentForm').attr('action'),
                        type: "PATCH",
                        dataType: "html",
                        success: function (data) {
                            start = 0;
                            managePostsCategoriesComments.show_all_comments();

                            $('div.flash-message').html(data);
                        }
                    })
                });

            },

            show_all: function () {
                var cc = managePostsCategoriesComments,
                    category_tbody = cc.category_tbody,
                    category_form = cc.category_form,
                    post_form = cc.post_form,
                    post_table = cc.post_table,
                    comment_table = cc.comment_table,
                    view_comment = cc.view_comment,
                    category_table = cc.category_table;

                    if( category_form.is(':visible') ) {

                        category_form.hide();
                    }

                    if( post_form.is(':visible') ) {

                        post_form.hide();
                    }

                    if( post_table.is(':visible') ) {

                        post_table.hide();
                    }

                    if( comment_table.is(':visible') ) {

                        comment_table.hide();
                    }

                    if( view_comment.is(':visible') ) {

                        view_comment.hide();
                    }

                $.get("{{ route('category.index') }}", function (data) {

                    $('#dashboard_header').html('Categories');
                    category_table.show();

                    $('.pages').remove();
                    $('.checked').remove();

                    category_tbody.empty();
                    var max_size = data.length;
                    
                    var limit = start + elements_per_page;

                    goFun(start, limit);
                    function goFun(current, limit) {
                        var current_page = (current + elements_per_page) / elements_per_page;
                        $('a.checked').attr('class', 'pages');
                        $('a[number="' + current_page + '"]').attr('class', 'checked');

                        for(var i = current; i < limit && i < max_size; i++) {
                        
                            var created = new Date(data[i]['created_at']);
                                var month = created.getMonth();
                                month++;
                                created = created.getDate() + '-' + month + '-' + created.getFullYear() + " " + created.getHours() + ":" + created.getMinutes() + ":" + created.getSeconds();

                            var updated = new Date(data[i]['updated_at']);
                                month = updated.getMonth();
                                month++;
                                updated = updated.getDate() + '-' + month + '-' + updated.getFullYear()  + " " + updated.getHours() + ":" + updated.getMinutes() + ":" + updated.getSeconds();

                            var current_row = $('<tr><td>' + data[i]['name'] + '</td><td>' + data[i]['description']  + '</td><td>' + data[i]['posts'] + '</td><td>' + created + '</td><td>' + updated + '</td><td class="actions"></td></tr>');
                            category_tbody.append(current_row);

                            
                            managePostsCategoriesComments.add_delete.call(data[i]);
                            managePostsCategoriesComments.add_edit.call(data[i]['id']);
                        }
                    }

                    for(var j = 0; j < max_size / elements_per_page; ) {
                        j++;
                        
                        $('<a number="' + j + '" class="pages">' + j + '</a>')
                            .insertBefore('.nextValue')
                            .on('click', function () {
                                
                                limit = elements_per_page;
                                var current = ($(this).attr('number') - 1) * limit;
                                limit = current + elements_per_page;

                                category_tbody.empty();
                                goFun(current, limit);
                            });
                            
                        var page = (start / elements_per_page ) + 1;   
                        $('a[number="' + page + '"]').attr('class', 'checked');
                    }

                });
            },

            show_create: function() {
                
                var cc = managePostsCategoriesComments,
                    category_form = cc.category_form,
                    category_table = cc.category_table,
                    post_form = cc.post_form,
                    post_table = cc.post_table,
                    comment_table = cc.comment_table,
                    view_comment = cc.view_comment,
                    page = $('a.checked').attr('id');
                    
                start = (page - 1) * elements_per_page;

                if( category_form.is(':visible') ) {

                    category_form.hide();
                }

                if( category_table.is(':visible') ) {

                    category_table.hide();
                }

                if( post_form.is(':visible') ) {

                    post_form.hide();
                }

                if( post_table.is(':visible') ) {

                    post_table.hide();
                }

                if( comment_table.is(':visible') ) {
                        
                    comment_table.hide();
                }

                if( view_comment.is(':visible') ) {

                    view_comment.hide();
                }

                $.get("{{ route('category.index') }}", function () {
                    category_form.show();
                    $('#create_category_form').attr('action', "{{ route('category.store') }}");
                    $('input[name="_method"]').attr('value', "POST");
                    $('#dashboard_header').html('Create Category');
                    $('#name').val(null);
                    $('#description').val(null);
                    $('#submitBtn').html('Save');
                    $('.cancelCategoryBtn').unbind('click');
                    $('.cancelCategoryBtn').on('click', function (e) {

                        e.preventDefault();
                        category_form.hide();
                        $('#dashboard_header').html('Dashboard');
                    });
                   
                });
            },

            show_create_post: function() {

                var cc = managePostsCategoriesComments,
                    category_form = cc.category_form,
                    category_table = cc.category_table,
                    post_form = cc.post_form,
                    post_table = cc.post_table,
                    comment_table = cc.comment_table,
                    view_comment = cc.view_comment,
                    page = $('a.checked').attr('id');
                    
                start = (page - 1) * elements_per_page;

                if( category_form.is(':visible') ) {

                    category_form.hide();
                }

                if( category_table.is(':visible') ) {

                    category_table.hide();
                }

                if( post_form.is(':visible') ) {

                    post_form.hide();
                }

                if( post_table.is(':visible') ) {

                    post_table.hide();
                }

                if( comment_table.is(':visible') ) {
                        
                    comment_table.hide();
                }

                if( view_comment.is(':visible') ) {

                    view_comment.hide();
                }

                $.get("{{ route('post.index') }}", function () {
                    post_form.show();
                    $('#dashboard_header').html('Create New Post');
                    $('#create_post_form').attr('action', "{{ route('post.store') }}");
                    $('input[name="_method"]').attr('value', "POST");
                    $('#post_id').val(null);
                    $('#post_name').val(null);
                    $('#checkbox-list').empty();
                    $('#checkbox-list').attr('hidden', true);
                    $('.checkbox-list-button').attr('area-expanded', false);
                    $('select[name="status"] option[value="draft"]').prop('selected', true);
                    CKEDITOR.instances['summary-ckeditor'].setData(null);
                    $('#submitPost').html('Save');
                    $('.cancelPostBtn').unbind('click');
                    $('.cancelPostBtn').on('click', function (e) {

                        e.preventDefault();
                        post_form.hide();
                        $('#dashboard_header').html('Dashboard');
                    });
                    
                });
            },

            show_edit: function() {

                var cc = managePostsCategoriesComments,
                    category_form = cc.category_form,
                    category_table = cc.category_table,
                    categoryId = $(this).data('id'),
                    page = $('a.checked').attr('number');
  
                start = (page - 1) * elements_per_page;

                category_table.hide();

                $.get("{{ route('category.index') }}" + '/' + categoryId + '/edit', function (data) {

                    category_form.show();
                    $('#create_category_form').attr('action', "{{ route('category.store') }}" + '/' + data.id);
                    $('#create_category_form').prepend('@method("PATCH")');
                    $('#dashboard_header').html('Edit Category');
                    $('#name').val(data.name);
                    $('#description').val(data.description);
                    $('#submitBtn').html('Save Changes');
                    $('.cancelCategoryBtn').on('click', function (e) {

                        e.preventDefault();
                        cc.show_all();
                    });
                    
                });
            },

            show_edit_post: function() {
                
                var cc= managePostsCategoriesComments,
                    post_form = cc.post_form,
                    post_table = cc.post_table,
                    postId = $(this).data('id');
                    page = $('a.checked').attr('number');

                start = (page - 1) * elements_per_page;

                post_table.hide();

                $.get("{{ route('post.index') }}" + '/' + postId + '/edit', function (data) {

                    post_form.show();
                    $('#create_post_form').attr('action', "{{ route('post.store') }}" + '/' + data.slug);
                    $('#create_post_form').prepend('@method("PATCH")');
                    $('#post_id').val(data.id);
                    $('#dashboard_header').html('Edit Post');
                    $('#post_name').val(data.title);
                    $('#checkbox-list').attr('hidden', true);
                    $('.checkbox-list-button').attr('area-expanded', false);
                    $('.checkbox-list-button').click();

                    if(data.published_at){
                        $('select[name="status"] option[value="publish"]').prop('selected', true);
                    }else{
                        $('select[name="status"] option[value="draft"]').prop('selected', true);
                    }

                    CKEDITOR.instances['summary-ckeditor'].setData(data.content);
                    $('#submitPost').html('Save Changes');
                    $('.cancelPostBtn').on('click', function (e) {

                        e.preventDefault();
                        cc.show_all_posts();
                    });
                });
            },

            show_all_posts: function () {
                var cc = managePostsCategoriesComments,
                    category_form = cc.category_form,
                    post_form = cc.post_form,
                    post_table = cc.post_table,
                    post_tbody = cc.post_tbody,
                    comment_table = cc.comment_table,
                    view_comment = cc.view_comment,
                    category_table = cc.category_table;

                    if( category_form.is(':visible') ) {

                      category_form.hide();
                    }

                    if( post_form.is(':visible') ) {

                        post_form.hide();
                    }

                    if( category_table.is(':visible') ) {

                        category_table.hide();
                    }

                    if( comment_table.is(':visible') ) {
                        
                        comment_table.hide();
                    }

                    if( view_comment.is(':visible') ) {

                        view_comment.hide();
                    }

                $.get("{{ route('post.index') }}", function (posts) {

                    $('#dashboard_header').html('Posts');
                    post_table.show();
                    

                    $('.pages').remove();
                    $('.checked').remove();

                    post_tbody.empty();
                    var max_size = posts.length;
                    
                    var limit = start + elements_per_page;

                    goFunPosts(start, limit);
                    function goFunPosts(current, limit) {
                        var current_page = (current + elements_per_page) / elements_per_page;
                        $('a.checked').attr('class', 'pages');
                        $('a[number="' + current_page + '"]').attr('class', 'checked');


                        for(var i = current; i < limit && i < max_size; i++) {
                        
                            var created = new Date(posts[i]['created_at']);
                                var month = created.getMonth();
                                month++;
                                created = created.getDate() + '-' + month + '-' + created.getFullYear() + " " + created.getHours() + ":" + created.getMinutes() + ":" + created.getSeconds();

                            var updated = new Date(posts[i]['updated_at']);
                                month = updated.getMonth();
                                month++;
                                updated = updated.getDate() + '-' + month + '-' + updated.getFullYear()  + " " + updated.getHours() + ":" + updated.getMinutes() + ":" + updated.getSeconds();

                            var url = "{{ route('post.show', ':slug') }}"
                            url = url.replace(':slug', posts[i]['slug']);

                            if(posts[i]['published_at']) {

                                var published = new Date(posts[i]['published_at']);
                                month = published.getMonth();
                                month++;
                                published = published.getDate() + '-' + month + '-' + published.getFullYear();
                                published = "Published </br>" + published;
                            } else {

                                var published = "In Draft";
                            }

                            var current_row = $('<tr><td><a href = "' + url + '">' + posts[i]['title'] + '</a></td><td>' + posts[i]['author'] + '</td><td>' + posts[i]['categories'].length + '</td><td>' + posts[i]['comments'].length + '</td><td>' + created + '</td><td>' + updated + '</td><td>' + published + '</td><td class="actions"></td></tr>');
                            post_tbody.append(current_row);

                            managePostsCategoriesComments.add_delete_post.call(posts[i]);
                            managePostsCategoriesComments.add_edit_post.call(posts[i]['id']);
                        }
                    }

                    for(var j = 0; j < max_size / elements_per_page; ) {
                        j++;
                        
                        $('<a number="' + j + '" class="pages">' + j + '</a>')
                            .insertBefore('.nextValue')
                            .on('click', function () {
                                
                                limit = elements_per_page;
                                var current = ($(this).attr('number') - 1) * limit;
                                limit = current + elements_per_page;

                                post_tbody.empty();
                                goFunPosts(current, limit);
                            });
                            
                        var page = (start / elements_per_page ) + 1;   
                        $('a[number="' + page + '"]').attr('class', 'checked');
                    }

                });
            },

            show_all_comments: function () {
                var cc = managePostsCategoriesComments,
                    category_form = cc.category_form,
                    post_form = cc.post_form,
                    post_table = cc.post_table,
                    post_tbody = cc.post_tbody,
                    comment_table = cc.comment_table,
                    comment_tbody = cc.comment_tbody,
                    view_comment = cc.view_comment,
                    category_table = cc.category_table;

                    if( category_form.is(':visible') ) {

                      category_form.hide();
                    }

                    if( post_form.is(':visible') ) {

                        post_form.hide();
                    }

                    if( category_table.is(':visible') ) {

                        category_table.hide();
                    }

                    if( post_table.is(':visible') ) {
                        
                        post_table.hide();
                    }

                    if( view_comment.is(':visible') ) {

                        view_comment.hide();
                    }

                $.get("{{ route('comment.index') }}", function (comments) {

                    $('#dashboard_header').html('Comments');
                    comment_table.show();
                    

                    $('.pages').remove();
                    $('.checked').remove();

                    comment_tbody.empty();
                    var max_size = comments.length;
                    
                    var limit = start + elements_per_page;
                    var pos = start;

                    goFunComments(start, limit);
                    function goFunComments(current, limit) {
                        var current_page = (current + elements_per_page) / elements_per_page;
                        $('a.checked').attr('class', 'pages');
                        $('a[number="' + current_page + '"]').attr('class', 'checked');

                        for(var i = current; i < limit && i < max_size; i++) {
                        
                            var created = new Date(comments[i]['created_at']);
                                month = created.getMonth();
                                month++;
                                created = created.getDate() + '-' + month + '-' + created.getFullYear() + " " + created.getHours() + ":" + created.getMinutes() + ":" + created.getSeconds();

                            var url = "{{ route('post.show', ':id') }}"
                            url = url.replace(':id', comments[i]['post_id']);

                            var description = comments[i]['description'].substr(0, 100);

                            if(comments[i]['description'].length > 100)
                            {
                                description = description + "...";
                            }

                            var current_row = $('<tr><td>' + comments[i]['author'] + "</br>" + comments[i]['email'] + '</td><td style="width: 400px;">' + description + '</td><td><a href="' + url + '">' + comments[i]['post'] + '</a></td><td>' + created + '</td><td class="actions" style="width: 300px;"></td></tr>');
                            comment_tbody.append(current_row);

                            cc.add_delete_comment.call(comments[i]);
                            cc.add_view_comment.call(comments[i]);
                            cc.add_approve_comment.call(comments[i]);
                        }
                    }

                    for(var j = 0; j < max_size / elements_per_page; ) {
                        j++;
                        
                        $('<a number="' + j + '" class="pages">' + j + '</a>')
                            .insertBefore('.nextValue')
                            .on('click', function () {
                                
                                limit = elements_per_page;
                                var current = ($(this).attr('number') - 1) * limit;
                                limit = current + elements_per_page;

                                comment_tbody.empty();
                                goFunComments(current, limit);
                            });
                            
                        var page = (pos / elements_per_page ) + 1;   
                        $('a[number="' + page + '"]').attr('class', 'checked');
                    }

                });
            },

            add_edit: function() {
                var id_of_category = this;

                $('<button class="btn btn-success" data-id="' + id_of_category + '">Edit</button>')
                    .prependTo($('#category_tbody td').last())
                    .on('click', managePostsCategoriesComments.show_edit);
            },

            add_delete: function() {
                var category = this;

                $('<button class="btn btn-danger deleteCategory">Delete</button>')
                    .prependTo($('#category_tbody td').last())
                    .on('click', function () {

                        $('#ajaxModal').modal('show');
                        $('#modalHeading').html('Delete Category');
                        $('#modal_name').html("Are you sure you want to delete the <strong>" + category['name'] + "</strong> category? It will no longer be available for use once deleted.");
                        $('#deleteCategoryForm').attr("action", "{{ route('category.index') }}" + '/' + category['id']);
                    });
            },

            add_edit_post: function() {
                var id_of_post = this;

                $('<button class="btn btn-success" data-id="' + id_of_post + '">Edit</button>')
                    .prependTo($('#post_tbody td').last())
                    .on('click', function () {
                        managePostsCategoriesComments.show_edit_post.call(this);
                    });
            },

            add_delete_post: function() {
                var post = this;

                $('<button class="btn btn-danger deletePost">Delete</button>')
                    .prependTo($('#post_tbody td').last())
                    .on('click', function () {

                        $('#ajaxModal').modal('show');
                        $('#modalHeading').html('Delete Post');
                        $('#modal_name').html("Are you sure you want to delete the <strong>" + post['title'] + "</strong> post? It will no longer be available for use once deleted.");
                        $('#deleteCategoryForm').attr("action", "{{ route('post.index') }}" + '/' + post['slug']);
                    });
            },

            add_approve_comment: function() {
                var comment = this;

                $('<button class="btn btn-success" data-id="' + comment['id'] + '">Approve</button>')
                    .prependTo($('#comment_tbody td').last())
                    .on('click', function () {

                        $('#approveCommentModal').modal('show');
                        $('#commentModalHeading').html('Approve Comment');
                        $('#modal_content').html("Are you sure you want to approve <strong>" + comment['author'] + "'s</strong> comment. After approved all end-users will be able to see it on the <strong>" + comment['post'] + "</strong> post.");
                        $('#approveCommentForm').attr("action", "{{ route('comment.index') }}" + '/' + comment['id']);
                    });
            },

            add_delete_comment: function() {
                var comment = this;

                $('<button class="btn btn-danger" data-id="' + comment['id'] + '">Delete</button>')
                    .prependTo($('#comment_tbody td').last())
                    .on('click', function () {

                        $('#ajaxModal').modal('show');
                        $('#modalHeading').html('Delete Comment');
                        $('#modal_name').html("Are you sure you want to delete <strong>" + comment['author'] + "'s</strong> comment. After deleted it will never be able to appear on the <strong>" + comment['post'] + "</strong> post to be seen by end-users.");
                        $('#deleteCategoryForm').attr("action", "{{ route('comment.index') }}" + '/' + comment['id']);
                        $('#deleteBtn').attr("element", "comment");
                    });
            },

            add_view_comment: function() {
                var comment = this;

                $('<button class="btn btn-primary" data-id="' + comment['id'] + '">View</button>')
                    .prependTo($('#comment_tbody td').last())
                    .on('click', function () {
                        var page = $('a.checked').attr('number');
                        start = (page - 1) * elements_per_page;

                        $('#comment_table').hide();

                        $('#dashboard_header').html('View Comment');
                        $('#view_comment').show();
                        $('img#image').attr('src', "/uploads/avatars/" + comment['avatar']);
                        $('#commenter').html(comment['author']);
                        $('#commenter_email').html(comment['email']);
                        $('#comment_content').html(comment['description']);
                        $('#hideComment').on('click', managePostsCategoriesComments.show_all_comments);
                    });
            }
        };

        managePostsCategoriesComments.init();
    })();
</script>
</html>