@extends('layouts.main')
@section('content')
<div class="bg-dark m-b-30">
    <div class="container">
        <div class="row p-b-60 p-t-60">

            <div class="col-md-8 m-auto text-white p-b-30">
                <div class="media">

                    <div class="media-body">
                        <span class="btn btn-white-translucent"><i class="mdi mdi-coins "></i></span>
                        <h2>
                            Stripe Payment
                        </h2>
                        <p class="opacity-75">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At autem corporis dicta
                            dignissimos earum ex facere fuga, impedit itaque minima nisi numquam officiis quisquam sequi
                            sint sit sunt tempora voluptate
                        </p>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<div class="pull-up">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 m-b-30 col-xlg-3">
                <div class="card">
                    <form action="{{ route('project.pay', ['id' => $project->id]) }}"  method="post" id="payment-form">
                        @csrf                    
                        <div class="form-group">
                            <div class="card-header">
                                <label for="card-element">
                                    Enter your credit card information
                                </label>
                            </div>
                            <div class="card-body">
                                <div id="card-element">
                                <!-- A Stripe Element will be inserted here. -->
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                                <input type="hidden" name="plan" value="" />
                                <input type="hidden" name="payment_method" value="Stripe" />
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="card-button" class="btn btn-dark" type="submit" data-secret="{{ $stripe_intent }}" > Pay {{$project->budget}} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<!--Additional Page includes-->
<script src="https://js.stripe.com/v3/"></script>
<script>
    var style = {
    base: {
        color: '#32325d',
        lineHeight: '18px',
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

    const stripe = Stripe('{{ $publishable_key }}', { locale: 'en' }); // Create a Stripe client.
    const elements = stripe.elements(); // Create an instance of Elements.
    const cardElement = elements.create('card', { style: style }); // Create an instance of the card Element.
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardElement.mount('#card-element'); // Add an instance of the card Element into the `card-element` <div>.

    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function(event) {
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

        stripe.handleCardPayment(clientSecret, cardElement, {
            payment_method_data: {
                //billing_details: { name: cardHolderName.value }
            }
        })
        .then(function(result) {
            console.log(result);
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                console.log(result);
                form.submit();
            }
        });
    });
</script>
<!--chart data for current dashboard-->
@endsection
