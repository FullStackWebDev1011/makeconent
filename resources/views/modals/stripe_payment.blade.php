<style>
    .label {
        padding: 5px 10px;
        background: lightgray;
    }
</style>
<div class="modal fade" id="stripe_payment_modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <form action="{{ route('stripe.deposit') }}" method="post" id="payment-form">
        <div class="modal-dialog modal-dialog-centered modal-md"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Payment with stripe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <div class="card-body">
                            <div class='form-row'>
                                <div class='col-md-12 form-group required'>
                                    <label class='control-label'>Enter your credit card information <span class="text-red">*</span></label> 
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                    </div>
                                </div>
                            </div>
                            <div id="card-errors" role="alert"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancel Deposit </button>
                    <button class="btn btn-primary" type="submit"> Pay {{$project->amount}}»</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
// Create a Stripe client.
var stripe = Stripe('{{$stripe_key}}');
  
// Create an instance of Elements.
var elements = stripe.elements();
  
// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        }
    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};
  
// Create an instance of the card Element.
var card = elements.create('card', {style: style});
  
// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');
  
// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});
  
// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
    event.preventDefault();
  
    stripe.createToken(card).then(function(result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});
  
// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
  
    // Submit the form
    form.submit();
}
</script>