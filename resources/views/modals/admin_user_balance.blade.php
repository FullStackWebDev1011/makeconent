<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="admin_balance_modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('/admin/balance/update') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Bonus Code</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">
                        <input type="hidden" value="{{ $member->id }}" name="id">
                        <div class="input-group">
                            <span class="label input-group-addon">Balance</span>
                            <input type="text" class="form-control" name="balance"
                                   value="{{ old('balance') ?? $member->wallet ? $member->wallet->total_balance : 0 }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


