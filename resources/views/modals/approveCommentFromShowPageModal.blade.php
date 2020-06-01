<!-- Approve Comment from show page Modal -->

<div class="modal modal-fade" id="approve-comment-{{ $comment->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Approve Comment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
        
        <form method="POST" class="form-horizontal" action="{{ route('comment.update', $comment->id) }}">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    Are you sure you want to approve this comment? Once approved all users will
                    be able to see it on the public post.
                </div>
            
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>