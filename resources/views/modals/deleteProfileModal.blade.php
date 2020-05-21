<!-- Delete Profile Modal -->

<div class="modal modal-danger fade" id="delete-profile-{{ Auth::user()->id }}" tabIndex="-1" role="dialog">
<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" area-label="Close">x</button>
            </div>
            <form method="POST" enctype="multipart/form-control" action="/profile/{{ Auth::user()->id }}">
                @csrf
                @method('DELETE')
            <div class="modal-body">
                <input type="hidden" name="_method" value="DELETE">
                <p class="text-center">
                    Are you sure you want to delete your profile?
                </p>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>