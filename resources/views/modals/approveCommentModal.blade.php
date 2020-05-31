<!-- Approve Comment Modal -->

<div class="modal modal-fade" id="approveCommentModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="commentModalHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
        
            <form method="POST" id="approveCommentForm" name="categoryForm" class="form-horizontal" action="">
                @csrf
                @method('PATCH')

                <div class="modal-body">
                    <p id="modal_content"></p>
                </div>
            
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit"  id="approveBtn">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>