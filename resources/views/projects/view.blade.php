@extends('layouts.main')
@section('content')
    <section class="admin-content">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->
        <!--  container or container-fluid as per your need           -->
        <div class="bg-dark">
            <div class="container  m-b-30">
                <div class="row">
                    <div class="col-12 text-white p-t-40 p-b-90">
                        <h4 class=""> <span class="btn btn-white-translucent">
                                <i class="mdi mdi-format-text "></i></span> Your order # {{$project->id}}
                        </h4>
                        <p class="opacity-75 ">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus culpa dolor
                            inventore reiciendis repellat temporibus ullam unde velit voluptatem. Accusamus
                            animi cupiditate eius expedita impedit nulla similique veniam voluptas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container  pull-up">
            <div class="row">
                <div class="col-md-12">
                    <form method="post" action="{{ route('project.pay')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $project->id }}">
                        <!--widget card begin-->
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="m-b-0">
                                    {{ $project->title }}
                                </h5>
                                <div class="text-md-right">
                                    <span class=" badge badge-soft-primary"> Language : {{$languages[$project->language]}}</span>
                                    <span class=" badge badge-soft-info"> {{$project->status}}</span>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="col-md-12">
                                    <h4>Description:</h4>
                                    <p>{{ $project->description }}</p>
                                </div>

                                <div class="col-md-12 row">
                                    <div class="col-md-2">
                                        <h5> Text Lenght: <br><span class="text-muted ml-3 small">{{ $project->min_chars }}
                                                ZZS</span>
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5> Price: <br><span class="text-muted ml-3 small">{{ roundPrice($project->budget) }}
                                                PLN</span>
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <h5> Rate: <br><span class="text-muted ml-3 small">{{ roundPrice($project->rate) }}
                                                PLN</span>
                                        </h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="mt-0 mb-1"> Need Bold Keywords?: <br><span
                                                    class="text-muted ml-3 small">
                                            {{ $project->cp_bold_keyword == 1?'Yes':'No' }}
                                        </span>
                                        </h5>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="mt-0 mb-1"> Need Text Tittle?: <br><span
                                                    class="text-muted ml-3 small">
                                            {{ $project->cp_write_title == 1?'Yes':'No' }}
                                        </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="text-md-right">
                                @if($project->status === 'sketch')
                                    <a class="btn m-b-15 ml-2 mr-2 btn-primary" href="javascript: payForProject()">Pay
                                        for Project</a>
                                    <a class="btn m-b-15 ml-2 mr-2 btn-primary" href="javascript: changePrice()">Change
                                        Price</a>
                                    <a class="btn m-b-15 ml-2 mr-2 btn-primary" href="javascript: cancelOrder()">Cancel
                                        Order</a>
                                @elseif($project->status === 'open')
                                    <a class="btn m-b-15 ml-2 mr-2 btn-primary" href="javascript: changePrice()">Change
                                        Price</a>
                                    <a class="btn m-b-15 ml-2 mr-2 btn-primary" href="javascript: cancelOrder()">Cancel
                                        Order</a>
                                @endif
                            </div>
                        </div>
                    </form>

                </div>

                <div class="col-md-12 m-b-30">
                    <h5>Your order text's</h5>
                    <div class="table-responsive">
                        <table class="table align-td-middle table-card">
                            <thead>
                            <tr>
                                <th>Copywriter</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($project->seller)
                                <tr>
                                    <td>
                                        <div class="media col-8 align-items-center">
                                            <div class="avatar avatar">
                                                @if($project->seller->avatar)
                                                    <img src="{{asset($project->seller->avatar)}}" alt="Seller"
                                                         class="avatar-img rounded-circle">
                                                @else
                                                    <img src="{{asset('assets/img/users/avatar.png')}}" alt="Seller"
                                                         class="avatar-img rounded-circle">
                                                @endif
                                            </div>
                                            <div class="media-body  ml-2">
                                                <div class=" text-truncate">
                                                    <a href="{{ route('profile', ['user' => $project->seller]) }}">
                                                        {{ $project->seller->getFullName() }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($project->seller_title, 35) }}</td>
                                    <td><span class="badge badge-soft-success">{{ $project->status }}</span></td>
                                    <td>
                                        @switch($project->status)
                                            @case(\App\Project::STATUS_ACCEPTED)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#project_text_view_modal">View Text
                                            </button>
                                            @if(!$project->rated)
                                                <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#project_copywriter_review_modal">Review Copywriter
                                                </button>
                                            @endif
                                            @break
                                            @case(\App\Project::STATUS_PENDING)
                                            Wait text from copywriter...
                                            @break
                                            @case(\App\Project::STATUS_WRITTEN)
                                            <button class="btn btn-primary" data-toggle="modal" data-target="#project_text_review_modal">Review Text
                                            </button>
                                            @break
                                            @default

                                            @break
                                        @endswitch
                                    </td>

                                </tr>
                            @else
                                <tr>
                                    <td class="text-center" colspan="4">No Text</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </div>

        <!-- END PLACE PAGE CONTENT HERE -->
        @include('modals.user_change_project_price')
        @include('modals.pay_for_project_modal')
        @include('modals.project_text_review')
        @include('modals.project_text_review_amendments')
        @include('modals.project_text_view')

        @if(!$project->rated)
            @include('modals.project_copywriter_review')
        @endif
    </section>
@endsection

@section('script')
    <script>
        var orderId = '{{$project->id}}';

        function pay() {
            $.get('{{ route('project.pay') }}' + '?id=' + orderId, function (res) {
                if (res.status === false) {
                    $.notify({
                        // options
                        title: 'Warning',
                        message: res.message
                    }, {
                        placement: {
                            align: "right",
                            from: "bottom"
                        },
                        timer: 500,
                        // settings
                        type: 'danger',
                    });
                } else {
                    location.reload();
                }
            });
        }

        function changePrice() {
            $('#project_price_change').modal('show');
        }

        $(function () {
            updateUpdatePriceData();

            $('#project_price_change [name=budget]').on('change', function () {
                updateUpdatePriceData();
            });

//            $('#project_price_change [name=budget]').keyup(function () {
//                updateUpdatePriceData();
//            });
        });

        function updateUpdatePriceData() {
            var oldPrice = parseFloat($('#project_price_change [name=budget]').attr('min')).toPrecision(12);
            var newPrice = parseFloat($('#project_price_change [name=budget]').val()).toPrecision(12);

            var totalSymbols = parseFloat($('#project_price_change #project_total_symbols').text()).toPrecision(12);
            var minPricePer1k = parseFloat($('#project_price_change #project_min_price_per_1k_by_category').text()).toPrecision(12);

            var totalKkSymbols = totalSymbols / 1000;

            var pricePer1kSymbols = Math.round(newPrice / totalKkSymbols * 100) / 100;

            var isUpdatePriceField = false;
            if (pricePer1kSymbols < minPricePer1k) {
                pricePer1kSymbols = minPricePer1k;
                isUpdatePriceField = true;
            }

            var totalPrice = Math.round(totalKkSymbols * pricePer1kSymbols * 100) / 100;

            if (isUpdatePriceField) {
                $('#project_price_change [name=budget]').val(Math.round(totalPrice * 10) / 10);
            }

            $('#project_price_change #price_per_1k_symbols').text(Math.round(pricePer1kSymbols * 100) / 100);
            $('#project_price_change #price_extra_cost').text(Math.round((newPrice - oldPrice) * 100) / 100);
        }

        function payForProject() {
            $('#project_pay_for_project').modal('show');
        }

        function cancelOrder() {
            $.get('{{route('project.cancel')}}' + '?id=' + orderId, function (res) {
                if (res.status === false) {
                    $.notify({
                        // options
                        title: 'Warning',
                        message: res.message
                    }, {
                        placement: {
                            align: "right",
                            from: "bottom"
                        },
                        timer: 500,
                        // settings
                        type: 'danger',
                    });
                }else {
                    location.reload();
                }
            })
        }

        $(function () {

            $("input[name=payment_method]").change(function (v) {
                switch(v.target.value) {
                    case "PayU":
                        $("#btnPayPayu").show()
                        $("#btnPayStripe").hide()
                        $("#btnPayWallet").hide()
                        break;
                    case "Stripe":
                        $("#btnPayStripe").show()
                        $("#btnPayPayu").hide()
                        $("#btnPayWallet").hide()
                        break;
                    case "wallet":
                        $("#btnPayWallet").show()
                        $("#btnPayPayu").hide()
                        $("#btnPayStripe").hide()
                        break;
                    default:
                        // code block
                }
            });

            @if(session()->has('success'))
                @if(session()->get('success') == true)
                $.notify({
                    // options
                    title: 'Successfully',
                    message: 'Price updated'
                }, {
                    placement: {
                        align: "right",
                        from: "bottom"
                    },
                    timer: 500,
                    // settings
                    type: 'success',
                });
                @else
                $.notify({
                    // options
                    title: 'Error',
                    message: 'Price not updated'
                }, {
                    placement: {
                        align: "right",
                        from: "bottom"
                    },
                    timer: 1500,
                    // settings
                    type: 'warning',
                });
                @endif
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
        });
    </script>
@endsection