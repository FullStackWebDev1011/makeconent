<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="admin_add_transaction_modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('/admin/transaction/add') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Add Transaction</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <input type="hidden" value="{{ $member->id }}" name="id">
                    <div class="container">
                        <div class="form-group">
                            <label>Type of Transaction <span class="text-red">*</span></label>
                            <select class="form-control custom-select" name="type">
                                <option selected disabled>Select one</option>
                                <option value="deposit">Deposit</option>
                                <option value="withdrawal">Withdrawal</option>
                                <option value="order">Order</option>
                                <option value="buy">Buy</option>
                                <option value="sell">Sell</option>
                                <option value="refund">Refund</option>
                                <option value="fee">Fee</option>
                                <option value="bonus">Bonus</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Type<span class="text-red">*</span></label>
                            <select class="form-control custom-select" name="position">
                                <option selected disabled>Select one</option>
                                <option value="income">Income</option>
                                <option value="expenses">Expenses</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Currency <span class="text-red">*</span></label>
                            <input type="text" class="form-control" name="currency" required>
                        </div>
                        <div class="form-group">
                            <label>Amount <span class="text-red">*</span></label>
                            <input type="number" class="form-control" name="qty" required>
                        </div>
                        <div class="form-group">
                            <label>Source</label>
                            <input type="text" class="form-control" name="source">
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


