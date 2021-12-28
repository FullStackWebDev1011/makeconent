<div class="modal fade bd-example-modal-lg" id="modal-0" tabindex="-1"
     role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form action="{{ route('withdrawal') }}" name="company_form"
          method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered modal-lg"
             role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Withdraw
                        Settings</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <h3>Your account type
                        is {{ Auth::user()->isCompany?'Company':'Personal' }}</h3>
                    <p>

                    </p>
                    <input type="hidden" name="real_amount"
                           value="{{ $x3 }}">
                    <div class="">
                        <div class="card-header">
                            <h5 class="m-b-0">
                                Your Withdraw Request: {{ $total_balance }}
                                PLN
                            </h5>
                            <h5 class="m-b-0">
                                Your Tax: {{ formatNumber($tax)}}
                                PLN
                            </h5>
                            <h5 class="m-b-0">

                                Kwota Brutto: {{ formatNumber($info['bruto']) }}
                                PLN
                            </h5>

                            <h5 class="m-b-0"><h5 class="m-b-0">
                                    Koszt Uzyskania przychodu (20%):
                                    {{formatNumber($info['bruto_tax'])}} PLN
                                </h5>
                                <h5 class="m-b-0"><h5 class="m-b-0">
                                        Podstawa opodatkowania:
                                        {{formatNumber($info['podtava_opodot'])}} PLN
                                    </h5>
                                    <h5 class="m-b-0"><h5 class="m-b-0">
                                            Podatek dochodowy:
                                            {{formatNumber($info['podatek_dochodowy'])}} PLN
                                        </h5>
                                        <h5 class="m-b-0">
                                            Kwota do wypłaty
                                            : {{ formatNumber($info['kwota_do_wyplaty']) }} PLN

                                        </h5>

                                    </h5>


                                    <p class="m-b-0 text-muted">
                                        You Have Personal/Company Account XYZ
                                        description to sand
                                    </p>
                        </div>
                        <div class="card-body">
                            <div class="">
                                <div class="option-box">
                                    <input id="radio-new1"
                                           name="withdrawal_type"
                                           value="free"
                                           type="radio" checked>
                                    <label for="radio-new1">
                                                                                    <span class="radio-content">
                                                                                        <span class="h6 d-block">Free Withdraw <span
                                                                                                    class="badge-soft-info badge">0 PLN</span>
                                                                                        </span>
                                                                                        <span class="text-muted d-block m-b-10">
                                                                                            You have one free withdraw money in month.
                                                                                        </span>
                                                                                    </span>
                                    </label>
                                </div>
                                <div class="option-box">
                                    <input id="radio-new2"
                                           name="withdrawal_type"
                                           value="express"
                                           type="radio">
                                    <label for="radio-new2">
                                                                                    <span class="radio-content">
                                                                                        <span class="h6 d-block">Express Withdraw <span
                                                                                                    class="badge-soft-info badge">- 15 PLN</span></span>

                                                                                        <span class="text-muted d-block m-b-10">
                                                                                            You can unlimited withdraw method with express.
                                                                                        </span>
                                                                                    </span>
                                    </label>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel Withdraw
                    </button>
                    <button type="submit" class="btn btn-primary">Confirm
                        Withdraw
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>