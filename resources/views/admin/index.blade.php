@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                    @include('partials.flash-messages')
                    @include('partials.errors')

                    <div id="category_table">
                        <table class="table table-striped table-sm paginate">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Number of Posts</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="category_tbody">
                            </tbody>
                        </table>
                        <div class="pagination">
                            <a class="preValue">Prev</a><a class="nextValue">Next</a>
                        </div>
                    </div>

                    <div id="post_table">
                        <table class="table table-striped table-sm paginate">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Categories</th>
                                    <th>Comments</th>
                                    <th>Created at</th>
                                    <th>Last Modified</th>
                                    <th>Status</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="post_tbody">
                            </tbody>
                        </table>
                        <div class="pagination">
                            <a class="preValue">Prev</a><a class="nextValue">Next</a>
                        </div>
                    </div>

                    <div id="comment_table">
                        <table class="table table-striped table-sm paginate">
                            <thead>
                                <tr>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>In Response to</th>
                                    <th>Submitted on</th>
                                    <th class="actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="comment_tbody">
                            </tbody>
                        </table>
                        <div class="pagination">
                            <a class="preValue">Prev</a><a class="nextValue">Next</a>
                        </div>
                    </div>

                    <div id="category_form">

                        <form method="POST" enctype="multipart/form-data" action="" id="create_category_form">
                            @csrf

                            <label for="name">Name: </label>
                            <input type="text" name="name" placeholder="Enter name of Category" id="name" required>
                        
                            <label for="description">Description: </label>
                            <textarea name="description" placeholder="Description of category here" rows="4" id="description" required></textarea>
                    
                            <button class="btn btn-primary cancelCategoryBtn">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn"></button>
                        </form>
                    </div>

                    <div id="post_form">

                        <form method="POST" enctype="multipart/form-data" action="" id="create_post_form">
                            @csrf
                            <input type="hidden" name="post_id" id="post_id">

                            <label for="title">Title:</label>
                            <input tupe="text" name="title" id="post_name" required>

                            <label for="categories">Categories:</label>
                            <div id="checkbox-list">
                            </div>
                            <div>
                                <label for="status">Status:</label>
                                <select name="status">
                                    <option value="draft">Draft</option>
                                    <option value="publish">Published</option>
                                </select>
                            </div>
                            
                            <label for="content">Content:</label>
                            <textarea class="form-control" name="content" id="summary-ckeditor"></textarea>

                            <button class="btn btn-primary cancelPostBtn">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitPost"></button>
                        </form>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection