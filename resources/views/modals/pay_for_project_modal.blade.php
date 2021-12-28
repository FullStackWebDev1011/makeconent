<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }

</style>
<div class="modal fade bd-example-modal-xl" id="project_pay_for_project" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div style="max-width:600px;" class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('project.pay', ['id' => $project->id]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Pay for Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="market_create_modalbody">
                    <div class="container">
                        <div class="option-box">
                            <input id="payment_method1" class="payment_method" value="PayU" checked
                                name="payment_method" type="radio">
                            <label for="payment_method1">
                                <span class="radio-content">
                                    <span class="h6 d-block">Pay with PayU <span class="badge-soft-primary badge">+2,6%
                                            FEE</span>
                                    </span>
                                    <span class="text-muted m-b-41">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Accusantium blanditiis ducimus ipsa provident
                                        quae quaerat similique? Consequatur consequuntur
                                        cum, inventore nihil porro quis. Ad assumenda
                                        eligendi illum impedit quis totam.
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="option-box">
                            <input id="payment_method2" class="payment_method" value="Stripe" checked
                                name="payment_method" type="radio">
                            <label for="payment_method2">
                                <span class="radio-content">
                                    <span class="h6 d-block">Pay with Stripe <span class="badge-soft-primary badge">+2,6%
                                            FEE</span>
                                    </span>
                                    <span class="text-muted m-b-41">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Accusantium blanditiis ducimus ipsa provident
                                        quae quaerat similique? Consequatur consequuntur
                                        cum, inventore nihil porro quis. Ad assumenda
                                        eligendi illum impedit quis totam.
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="option-box">
                            <input id="payment_method3" class="payment_method" value="wallet" name="payment_method"
                                type="radio" required>
                            <label for="payment_method3">
                                <span class="radio-content">
                                    <span class="h6 d-block">Pay with your wallet funds
                                    </span>
                                    <span class="text-muted m-b-41">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit. Accusantium blanditiis ducimus ipsa provident
                                        quae quaerat similique? Consequatur consequuntur
                                        cum, inventore nihil porro quis. Ad assumenda
                                        eligendi illum impedit quis totam.
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                    <input type="hidden" name="redirect" value="{{ route('projects.view', ['project' => $project]) }}">
                    <button id="btnPayPayu" style="display: none" type="submit" class="btn btn-primary">Save With PayU</button>
                    <a href="{{route('stripe.checkout',['id'=>$project->id])}}" id="btnPayStripe" style="display: none" class="btn btn-primary">Save With Stripe</button>
                    <button id="btnPayWallet" style="display: none" type="submit" class="btn btn-primary">Save With Wallet</button>
                </div>
            </form>
        </div>
    </div>
</div>