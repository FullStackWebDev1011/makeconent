@extends('layouts.main')
@section('content')
    <section class="admin-content">
        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="col-12 text-white p-t-40 p-b-90">
                    <h4><span class="btn btn-white-translucent"><i class="mdi mdi-coins "></i></span>
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
                <div class="col-lg-7 m-b-30">
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
                                            <h4 class="text-success">{{ $wallet? formatNumber($wallet->total_balance):0,00 }} {{$country}} </h4>
                                        </div>
                                        <div class="col-md-4 p-t-15">
                                            <p class=" text-overline">
                                                Enterprise
                                            </p>
                                            <h5>Credit Balance</h5>
                                            <h4 class="text-success">{{ formatNumber($wallet?$wallet->credit_balance:0) }} {{$country}}</h4>
                                        </div>
                                        <div class="col-md-4 p-t-15">
                                            @if(auth()->user()->isCanAddFunds())
                                                <button type="button" data-toggle="modal" data-target="#deposit_modal"
                                                        class="btn m-b-15 ml-2 mr-2 btn-outline-primary">Add Funds with
                                                    PayU
                                                </button>
																								
                                                <button type="button" data-toggle="modal" data-target="#stripe_deposit_modal" class="btn m-b-15 ml-2 mr-2 btn-outline-primary">Add Funds with Stripe </button>
                                            @else
                                                <button type="button" data-toggle="modal"
                                                        data-target="#cant_founds_by_profile"
                                                        class="btn m-b-15 ml-2 mr-2 btn-outline-primary">Add Funds with
                                                    PayU
                                                </button>
                                                <button type="button" data-toggle="modal" data-target="#cant_founds_by_profile" class="btn m-b-15 ml-2 mr-2 btn-outline-primary">Add Funds with Stripe </button>
                                            @endif

                                            <button type="button" data-toggle="modal" data-target="#bonus_code_modal"
                                                    class="btn m-b-15 ml-2 mr-2 btn-outline-primary">Reedem Bonus Code
                                            </button>
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
                                       aria-controls="home" aria-selected="true">Wallet recharge history</a>
                                </li>
                                <li class="nav-item">
                                    <a class="tabHeader nav-link" id="profile-tab" href="javascript: setTab('profile')"
                                       aria-controls="profile" aria-selected="false">History of use of funds</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pillhome" role="tabpanel"
                                     aria-labelledby="home-tab">
                                 
                                    <div class="table-responsive p-t-10">
                                        <table class="table table-hover example table" style="width:100%">
                                            <thead class="">
                                            <tr>
                                                <th scope="col">ID #</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Method</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Ammount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($rechargeTransactions as $key=>$transaction)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{ $transaction->created_at }}</td>
                                                    <td>
                                                    <span class="text-capitalize">
                                                        {{ $transaction->type }} {{ $transaction->getPublicId() }}
                                                    </span>
                                                    </td>
                                                    <td>
                                                        @switch($transaction->status)
                                                            @case(\App\Transaction::STATUS_PENDING)
                                                            <span class=" text-dark"><i class="mdi mdi-watch "></i> Pending</span>
                                                            @break
                                                            @case(\App\Transaction::STATUS_CANCEL)
                                                            <span class=" text-danger"><i
                                                                        class="mdi mdi-close-circle "></i> Canceled</span>
                                                            @break
                                                            @case(\App\Transaction::STATUS_FINISH)
                                                            <span class=" text-success"><i
                                                                        class="mdi mdi-check-circle "></i> Finish</span>
                                                            @break
                                                        @endswitch
                                                    </td>
                                                    <td>{{ roundPrice($transaction->qty)}} {{$transaction->currency}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th scope="col">ID #</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Method</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Ammount</th>
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
                                                <th scope="col">ID #</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Method</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Ammount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($useFundsTransactions as $key=>$transaction)
                                                <tr>
                                                    <td>{{$key + 1}}</td>
                                                    <td>{{ $transaction->created_at }}</td>
                                                    <td>
                                                        <span class="text-capitalize">
                                                            {{ $transaction->type }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-capitalize">
									    <span class=" text-success"><i
                                                    class="mdi mdi-check-circle "></i> {{ $transaction->status }}</span>
                                                        </span>
                                                    </td>
                                                    <td>{{ formatNumber($transaction->qty) }} PLN</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th scope="col">ID #</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Method</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Ammount</th>
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
    @if(app()->environment() !== 'production')
        <a href="{{ route('notify.test', ['number' => '1']) }}">Test success</a><br>
        <a href="{{ route('notify.test', ['number' => '2']) }}">Test pending</a><br>
        <a href="{{ route('notify.test', ['number' => '3']) }}">Test fail</a><br>
    @endif

    @include('financial.components.deposit_modal')
    @include('financial.components.stripe_deposit_modal')
    @include('financial.components.bonus_code_modal')
    @include('financial.cant_founds_by_profile')
@endsection

@section('script')
    <!--Additional Page includes-->
    <script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable-data.js')}}"></script>
    <!--chart data for current dashboard-->
    <script>
        $(function () {
            $('#history').DataTable({
                ordering: true
            });
        });
    </script>
    <script>
        $(function () {
            @if(session()->has('status'))
            $.notify({
                // options
                title: 'Successfully',
                message: ''
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 2000,
                // settings
                type: 'success',
            });
            @endif

            @if(session()->has('payment_success'))
            $.notify({
                icon: 'icon mdi mdi-check-circle',
                title: 'Payment Finished',
                message: ''
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 2000,
                // settings
                type: 'success',
                template: '<div data-notify="container" class=" bootstrap-notify alert " role="alert">' + '<div class="progress" data-notify="progressbar">' + '<div class="progress-bar bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' + "</div>" + '<div class="media "> <div class="avatar m-r-10 avatar-sm"> <div class="avatar-title bg-{0} rounded-circle"><span data-notify="icon"></span></div> </div>' + '<div class="media-body"><div class="font-secondary" data-notify="title">{1}</div> ' + '<span class="opacity-75" data-notify="message">{2}</span></div>' + '<a href="{3}" target="{4}" data-notify="url"></a>' + ' <button type="button" aria-hidden="true" class="close" data-notify="dismiss"><span>x</span></button></div></div>'
            });
            @endif

            @if(session()->has('payment_pending'))
            $.notify({
                icon: 'mdi mdi-alert-circle',
                title: 'Payment Pending',
                message: ''
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 2000,
                // settings
                type: 'warning',
                template: '<div data-notify="container" class=" bootstrap-notify alert " role="alert">' + '<div class="progress" data-notify="progressbar">' + '<div class="progress-bar bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' + "</div>" + '<div class="media "> <div class="avatar m-r-10 avatar-sm"> <div class="avatar-title bg-{0} rounded-circle"><span data-notify="icon"></span></div> </div>' + '<div class="media-body"><div class="font-secondary" data-notify="title">{1}</div> ' + '<span class="opacity-75" data-notify="message">{2}</span></div>' + '<a href="{3}" target="{4}" data-notify="url"></a>' + ' <button type="button" aria-hidden="true" class="close" data-notify="dismiss"><span>x</span></button></div></div>'
            });
            @endif

            @if(session()->has('payment_cancel'))
            $.notify({
                icon: 'mdi mdi-alert-circle',
                title: 'Payment Canceled',
                message: ''
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 2000,
                // settings
                type: 'danger',
                template: '<div data-notify="container" class=" bootstrap-notify alert " role="alert">' + '<div class="progress" data-notify="progressbar">' + '<div class="progress-bar bg-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' + "</div>" + '<div class="media "> <div class="avatar m-r-10 avatar-sm"> <div class="avatar-title bg-{0} rounded-circle"><span data-notify="icon"></span></div> </div>' + '<div class="media-body"><div class="font-secondary" data-notify="title">{1}</div> ' + '<span class="opacity-75" data-notify="message">{2}</span></div>' + '<a href="{3}" target="{4}" data-notify="url"></a>' + ' <button type="button" aria-hidden="true" class="close" data-notify="dismiss"><span>x</span></button></div></div>'
            });
            @endif

            @if($errors->has('qty'))
            $.notify({
                // options
                title: 'Warning',
                message: '{{$errors->first('qty')}}'
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 500,
                // settings
                type: 'danger',
            });
            @endif
            @if($errors->has('code'))
            $.notify({
                // options
                title: 'Warning',
                message: '{{$errors->first('code')}}'
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 500,
                // settings
                type: 'danger',
            });
            @endif
            
            @if($errors->has('error'))
            $.notify({
                // options
                title: 'Warning',
                message: '{{$errors->first('error')}}'
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 500,
                // settings
                type: 'danger',
            });
            @endif

            @if(session()->has('error'))
            $.notify({
                // options
                title: 'Warning',
                message: '{{session()->get('error')}}'
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },
                timer: 500,
                // settings
                type: 'danger',
            });
            @endif
        });

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
    </script>
@endsection

