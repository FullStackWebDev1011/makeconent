<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade bd-example-modal-xl" id="admin_payment_modal" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">
			  <h5>Bill ID: <span class="js_invoice_id"></span></h5>
			  <h5>Payment Type: <span class="js_invoice_type"></span></h5>
			  <h5>User Email: <span class="js_invoice_email"></span></h5>
			   <h5>Adress: <span class="js_invoice_address"></span></h5>
			   <h5>Bank Account: <span class="js_invoice_bank_account"></span></h5>
                        <div class="input-group">
                            <span class="label input-group-addon">Invoice Number (Only if Buissness Acc)</span>
                            <input type="text" class="form-control" name="code" value="" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">Accept</button>
                </div>
            </form>
        </div>
    </div>
</div>


