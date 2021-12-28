<div class="modal fade" id="modal-0" tabindex="-1"
     role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form action="{{ route('withdrawal') }}" name="company_form"
          method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered"
             role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Can't withdraw</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Minimal widthdraw is {{ config('settings.payment.min_withdrawal_balance') }} PLN
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>