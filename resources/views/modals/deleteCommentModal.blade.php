<!-- Delete Comment from show page Modal -->

<div class="modal modal-fade" id="confirmDeleteCommentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Comment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
        
        <form method="POST" class="form-horizontal" action="">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    Are you sure you want to delete this comment? Once deleted it cannot be seen
                    on the post ever.
                </div>
            
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>