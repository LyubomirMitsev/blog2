<!-- Delete Post Modal -->

<div class="modal modal-fade" id="delete-post-{{ $post->slug }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeading">Delete Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
        
            <form method="POST" class="form-horizontal" action="{{ route('post.destroy', $post->slug) }}">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p>Are you sure you want to delete the {{ $post->name }} post? Once deleted
                    it will no longer be visable in the blog.</p>
                </div>
            
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>