<div class="modal fade" id="deposit_modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <form action="{{ route('deposit') }}" method="post">
        <div class="modal-dialog modal-dialog-centered modal-lg"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
{{--                    <div class="form-group">--}}
{{--                        <label for="email">--}}
{{--                            Email--}}
{{--                        </label>--}}
{{--                        <input class="form-control" id="email" placeholder="Account Email" name="email" type="email" required>--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label for="amount">
                            Amount (PLN)
                        </label>
                        <input class="form-control" id="amount" name="qty" type="number" min="0" placeholder="Amount" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel Deposit
                    </button>
                    <button type="submit" class="btn btn-primary">Confirm
                        Deposit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>