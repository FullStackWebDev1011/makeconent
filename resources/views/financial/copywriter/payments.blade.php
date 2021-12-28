@extends('layouts.main')
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="col-12 text-white p-t-40 p-b-90">
                    <h4><span class="btn btn-white-translucent"><i class="mdi mdi-format-color-text "></i></span>
                        Payments
                    </h4>
                    <p class="opacity-75 ">
                        Compartmentalizing the content using default bootstrap tabs layout. we
                        have added line tabs as additional representation of tabs.
                    </p>
                </div>
            </div>
        </div>
        <div class="container pull-up">
            <div class="row">
                <div class="col-lg-8 m-b-30">
                    @php
                        $total_balance = Auth::user()->wallet? Auth::user()->wallet->total_balance:0;
                        //$tax = $total_balance * config('settings.vat.pl');
                        $tax = $total_balance * 18.69918699186 / 100;
                        $x1 = $total_balance - $tax;
                        $info['bruto'] = $total_balance - $tax;
                        //dd($total_balance, formatNumber($tax), formatNumber($x1));
                        $x2 = $x1 * 0.2;
                        $info['bruto_tax'] = $x1 * 0.2;
                        $info['bruto_minus_tax'] = $total_balance - $info['bruto_tax'];
                        $x3 = $x1 - $x2;
                        $info['podtava_opodot'] = round($info['bruto']) - round($info['bruto_tax']);
                        $x4 = $x3 * 0.17;
                        $info['podatek_dochodowy'] = round($info['podtava_opodot'] * 0.17);
                        $x5 = $x1 - $x4;
                        $info['kwota_do_wyplaty'] = $info['bruto'] - $info['podatek_dochodowy'];
                    @endphp

                    <div class="row">
                        <div class="col-lg-12 m-b-30 ">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 p-t-15">
                                            <p class=" text-overline">
                                                Today
                                            </p>
                                            <h5>Account Balance</h5>
                                            <h4 class="text-success">{{ formatNumber($wallet->total_balance ?? 0) }} PLN</h4>
                                        </div>
                                        <div class="col-md-4 p-t-15">
                                            <p class=" text-overline">
                                                History
                                            </p>
                                            <h5>Withdraw Total</h5>
                                            <h4 class="text-success">{{ formatNumber($totalWithdrawal) }} PLN</h4>
                                        </div>
                                        <div class="col-md-4 p-t-15">
                                            <button type="button" data-toggle="modal"
                                                    data-target="#modal-{{Auth::user()->isCompany}}"
                                                    class="btn m-b-15 ml-2 mr-2 btn-outline-primary">Withdraw Funds
                                            </button>
                                            <p class=" text-overline">Minimal widthdraw is {{ config('settings.payment.min_withdrawal_balance') }} PLN</p>
                                            <div class="modal fade bd-example-modal-lg" id="modal-1" tabindex="-1"
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
                                                                <div class="">

                                                                    <div class="card-header">
                                                                        <h5 class="m-b-0">
                                                                            Your Withdraw Request: {{ formatNumber($total_balance) }}
                                                                            PLN
                                                                        </h5>
                                                                        <h5 class="m-b-0">
                                                                            Your Tax : {{ formatNumber($tax)}}
                                                                            PLN
                                                                        </h5>
                                                                        <h5 class="m-b-0">

                                                                            Kwota Brutto: {{ formatNumber($x1) }}
                                                                            PLN
                                                                        </h5>
                                                                        <input type="hidden" name="real_amount"
                                                                               value="{{ $x3 }}">
                                                                        <h5 class="m-b-0"><h5 class="m-b-0">
                                                                                Koszt Uzyskania przychodu (20%):
                                                                                {{formatNumber($x2)}} PLN (X1 - 20%)
                                                                            </h5>
                                                                            <h5 class="m-b-0">
                                                                                Podstawa
                                                                                Opodatkowania: {{ formatNumber($x3) }}
                                                                                PLN

                                                                            </h5>
                                                                            <h5 class="m-b-0">
                                                                                Podatek
                                                                                Dochodowy: {{ formatNumber($x4) }} PLN

                                                                            </h5>
                                                                            <h5 class="m-b-0">
                                                                                Kwota do wypłaty
                                                                                : {{ formatNumber($x5) }} PLN

                                                                            </h5>
                                                                            <p class="m-b-0 text-muted">
                                                                                Change your account type to Buissness
                                                                                and recive more! If you have buissness
                                                                                account you recive for this payment
                                                                            </p>
                                                                        </h5>
                                                                    </div>


                                                                    <div class="card-body">

                                                                        <div class="">
                                                                            <div class="option-box">
                                                                                <input id="radio-new11"
                                                                                       name="withdrawal_type"
                                                                                       value="free"
                                                                                       type="radio" checked>
                                                                                <label for="radio-new11">
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
                                                                                <input id="radio-new21"
                                                                                       name="withdrawal_type"
                                                                                       value="express"
                                                                                       type="radio">
                                                                                <label for="radio-new21">
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
                                            @if(!empty($wallet->total_balance) && $wallet->total_balance >= config('settings.payment.min_withdrawal_balance'))
                                                @include('modals.withdraw_founds_settings_modal')
                                            @else
                                                @include('modals.withdraw_cant_founds_modal')
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 m-b-30">

                    <!--card begins-->
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="card-title">Payment History</div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="tabHeader nav-link active" id="home-tab" href="javascript: setTab('home')"
                                       aria-controls="home" aria-selected="true">Withdraw History</a>
                                </li>
                                <li class="nav-item">
                                    <a class="tabHeader nav-link" id="profile-tab" href="javascript: setTab('profile')"
                                       aria-controls="profile" aria-selected="false">Wallet use of Funds
                                        History</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pillhome" role="tabpanel"
                                     aria-labelledby="home-tab">

                                    <div class="table-responsive p-t-10">
                                        <table class="example table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Quantity</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($rechargeTransactions as $key=>$transaction)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{ formatNumber($transaction->qty) }} PLN</td>
                                                    <td>{{ $transaction->type }}</td>
                                                    <td class="text-capitalize {{$transaction->status}}">{{ $transaction->status }}</td>
                                                    {{--                                                    <td>{{ 'Card Number : ' . $transaction->source}}</td>--}}
                                                    <td>{{ $transaction->created_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Quantity</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pillprofile" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    <div class="table-responsive p-t-10">
                                        <table class="table example" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Quantity</th>
                                                <th>Type</th>
                                                {{--<th>Source</th>--}}
                                                <th>Created Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($useFundsTransactions as $key=>$transaction)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{ $transaction->qty }}</td>
                                                    <td>{{ $transaction->type }}</td>
                                                    {{--<td>{{--}}
                                                    {{--(--}}
                                                    {{--$transaction->type === 'order'--}}
                                                    {{--? 'Order Id : ': 'Sell Id : '--}}
                                                    {{--)--}}
                                                    {{--. $transaction->source--}}
                                                    {{--}}</td>--}}
                                                    <td>{{ $transaction->created_at }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>No</th>
                                                <th>Quantity</th>
                                                <th>Type</th>
                                                {{--<th>Source</th>--}}
                                                <th>Created Date</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--card ends-->
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $('.example').DataTable({
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {"emptyTable": "No Transaction"}
        });

        function setTab(name) {
            console.log(name);
            $('.tabHeader').removeClass('active');
            $('.tab-pane').removeClass('show').removeClass('active');
            $('#' + name + '-tab').addClass('active');
            $('#pill' + name).addClass('show').addClass('active');
        }

        $(function () {
            $('#radio-new1').click();
            @if($errors->has('message'))
            $.notify({
                // options
                title: 'Warning',
                message: '{{ $errors->first('message') }}'
            }, {
                placement: {
                    align: "right",
                    from: "bottom"
                },
                timer: 500,
                // settings
                type: 'danger',
            });
            @endif
        })
    </script>
@endsection
