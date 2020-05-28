<!-- Delete Category or Post Modal -->

<div class="modal modal-fade" id="ajaxModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
        
            <form method="POST" id="deleteCategoryForm" name="categoryForm" class="form-horizontal" action="">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p id="modal_name"></p>
                </div>
            
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit"  id="deleteBtn">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>