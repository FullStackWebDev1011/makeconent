<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<?php
$totalAmount = 0;
$stripe = new \Stripe\StripeClient('sk_test_51IhvShAl7ip8OlX9PVZke4Rg7kbLcSXwvZrcCPAbgbcfoETLRqSJbZr12hAFJKQX9hwiE40xkbeBOhnSQDV2twFc00nOsibsKH');
$intent = $stripe->paymentIntents->create(
    [
        'amount' => 1099,
        'currency' => 'pln',
        'automatic_payment_methods' => ['enabled' => true],
    ]
);

?>
<div class="modal fade" id="stripe_deposit_modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <form action="{{ route('stripe.deposit') }}" method="post" id="payment-form"  data-secret="<?= $intent->client_secret ?>">
        <div class="modal-dialog modal-dialog-centered modal-xl"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Deposit with stripe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6" id="payment-element">
                            <!-- Elements will create form elements here -->
                        </div>
                        <div class="col-md-6 row">
                            <label for="deposit_amount" class="col-sm-5 col-form-label">Deposit Amount</label>
                            <div class="col-md-7">
                                <input type="number" class="form-control text-right" id="deposit_amount" onInput="depositAmountChanged()">
                            </div>
                            <div class="col-md-5">Processing Fee</div>
                            <div class="col-md-7 text-right">
                                <span id="depositFee">$00.00</span>
                            </div>
                            <div class="col-md-5 font-weight-bold">Total</div>
                            <div class="col-md-7 text-right">
                                <span id="totalDeposit">$00.00</span>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary w-100">Confirm and pay <span id="btnSpan">0</span> USD</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel Deposit </button>
                    <button class="btn btn-primary" type="submit"> Pay »</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://js.stripe.com/v3/"></script>

<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const options = {
        clientSecret: '<?= $intent->client_secret ?>',
    };

    var elements = stripe.elements(options);
    const paymentElement = elements.create('payment');
    paymentElement.mount('#payment-element');

    function depositAmountChanged() {
        var inputDepositAmount = document.getElementById("deposit_amount");
        var spanFee = document.getElementById("depositFee");
        var spanTotalDeposit = document.getElementById("totalDeposit");
        var btnTotalSpan = document.getElementById("btnSpan");

        var depositAmount = (isNaN(inputDepositAmount.value) ? 0 : inputDepositAmount.value);
        var depositFee = (depositAmount == 0) ? 0 : (depositAmount * 2.9) / 100 + 0.3;
        var totalDeposit = parseFloat(depositAmount) + parseFloat(depositFee);
        if (isNaN(totalDeposit)) totalDeposit = 0.0;
        spanFee.innerText = '$' + depositFee.toFixed(2);
        spanTotalDeposit.innerText = '$' + totalDeposit.toFixed(2);
        btnTotalSpan.innerText = totalDeposit.toFixed(2);
    }
</script>
