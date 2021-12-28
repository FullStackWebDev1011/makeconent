<div class="modal fade" id="cant_founds_by_profile" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"
         role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">You can't add founds</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Please, fill profile fields
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">
                    Cancel
                </button>
                <a href="{{ route('settings') }}" class="btn btn-primary">
                    Profile
                </a>
            </div>
        </div>
    </div>
</div>