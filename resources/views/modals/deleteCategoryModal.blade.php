<!-- Delete Category Modal -->

<div class="modal modal-fade" id="confirmDeleteCategoryModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalHeading">Delete Category</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
        
            <form method="POST" class="form-horizontal" action="">
                @csrf
                @method('DELETE')

                <div class="modal-body">
                    <p>Are you sure you want to delete this category? Once deleted
                    no posts can be associated with this category.</p>
                </div>
            
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>