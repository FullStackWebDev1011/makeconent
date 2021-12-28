<div class="modal fade" id="bonus_code_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="{{ route('bonus_receive') }}" method="post">
        <div class="modal-dialog modal-dialog-centered modal-lg"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Reedem Bonus</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="amount">
                            Code
                        </label>
                        <input class="form-control" id="code" name="code" type="text" min="0" placeholder="Bonus Code" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>