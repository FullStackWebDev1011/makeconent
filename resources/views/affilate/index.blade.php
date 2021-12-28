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
                            Affilacja
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
            <div class="col-lg-4 m-b-30 col-xlg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 p-t-15">
                                <p class=" text-overline">
                                    Total
                                </p>
                                <h5>Estimates</h5>
                                <h4 class="text-success">{{ roundPrice($total) }} PLN</h4>
                            </div>
                            <div class="col-md-8 p-t-15">
                                <div id="chart-11" class="chart-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 m-b-30 col-xlg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 p-t-15">
                                <p class=" text-overline">
                                    monthly
                                </p>
                                <h5>Estimates</h5>
                                <h4 class="text-success">{{ roundPrice($monthly) }} PLN</h4>
                            </div>
                            <div class="col-md-8 p-t-15">
                                <div id="chart-12" class="chart-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 m-b-30 col-xlg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 p-t-15">
                                <p class=" text-overline">
                                    daily
                                </p>
                                <h5>Estimates</h5>
                                <h4 class="text-success">{{ roundPrice($daily) }} PLN</h4>
                            </div>
                            <div class="col-md-8 p-t-15">
                                <div id="chart-13" class="chart-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4 m-b-30 col-xlg-3 visible-xlg">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 p-t-15">
                                <p class=" text-overline">
                                    Users Affilates
                                </p>
                                <h5>Estimates</h5>
                                <h4 class="text-success">1,392 UU</h4>
                            </div>
                            <div class="col-md-8 p-t-15">
                                <div id="chart-14" class="chart-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

    </div>
</div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-b-30">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="card-title m-b-0">Affilate Information</h5>


                </div>
                <div class="card-body">

                    <p class="card-text">Some quick example text to build on the card title and make up the bulk
                        of the card's content.</p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Autem cupiditate deleniti
                        dolore exercitationem explicabo facere ipsa itaque iusto, maiores minima modi molestias
                        nobis optio provident quas repudiandae tempore temporibus, voluptatem.
                    </p>
                </div>
                <div class="card-footer">
                    <div class="d-flex  justify-content-between">
                        <input class="m-b-0 my-auto form-control" type="text" value="{{ URL::to('/invite/'.auth()->user()->affiliate_code) }}" id="myInput">
                        <a href="#!" onclick="copyLink()" style="margin:5px;" class="col-md-2 btn btn-dark"> <i class="mdi mdi-content-copy"></i>Copy Link</a>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-6 m-b-30">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">User Renewals</div>

                    <div class="card-controls">

                        <a href="#" class="js-card-refresh icon"> </a>
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="icon mdi  mdi-dots-vertical"></i> </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button">Action</button>
                                <button class="dropdown-item" type="button">Another action</button>
                                <button class="dropdown-item" type="button">Something else here</button>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover table-sm ">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Team</th>
                                <th>location</th>
                                <th>Date</th>
                                <!-- <th class="text-center">Balance added</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renewals as $renewal)
                            <tr>
                                <td class="align-middle">

                                    <span class="ml-2">{{$renewal->user->first_name}}</span></td>

                                <td class="align-middle">
                                    @switch($renewal->user->levelType)
                                        @case(\App\UserLevel::TYPE_CLIENT)
                                            <span class="badge badge-soft-danger badge-light">User</span>
                                        @break
                                        @case(\App\UserLevel::TYPE_COPYWRITER)
                                            <span class="badge badge-soft-success"> Copywriter</span>
                                        @break
                                        @default
                                            <span class="badge badge-info"> -</span>
                                        @break
                                    @endswitch
                                </td>
                                <td class="align-middle">+ {{roundPrice($renewal->amount)}} PLN</td>
                                <td class="align-middle">
                                    {{$renewal->created_at}}
                                </td>
                                <!-- <td class="text-center align-middle"><a class="btn btn-primary btn-sm" href="#"> Connect</a></td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <div class="card-footer">
                    <div class="d-flex  justify-content-between">
                        <h6 class="m-b-0 my-auto"><span class="opacity-75"> <i class="mdi mdi-information"></i> Money
                                will be add to your balance today at 0:00.</span>
                        </h6>
                        <a href="{{ route('affilate_all') }}" class="btn btn-dark">View All</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<!--Additional Page includes-->
<script src="{{asset('assets/vendor/apexchart/apexcharts.min.js')}}"></script>
<script src="assets/vendor/affilate.js"></script>
<script>
    function copyLink() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");

        /* Select the text field */
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */

        /* Copy the text inside the text field */
        document.execCommand("copy");

        /* Alert the copied text */
        $.notify({
            // options
            title: 'Successfully',
            message: "Copied the text: " + copyText.value
        }, {
            placement: {
                align: "center",
                from: "top"
            },
            timer: 1000,
            // settings
            type: 'success',
        });
    }
    $(function(){
        if ($("#chart-11").length) {
            var options = {
                chart: {
                    type: 'area',
                    height: 100,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false,
                    },
                },

                stroke: {
                    colors: [colors[0]],
                    curve: 'straight',
                    width: 3
                },
                fill: {
                    opacity: 0.7,
                    gradient: {
                        enabled: false
                    }
                },
                series: [{
                    data: @json($chart_total)
                }],
                yaxis: {
                    min: 0
                },
                colors: colors[0],

            }
            var chart = new ApexCharts(
                document.querySelector("#chart-11"),
                options
            );

            chart.render();
        }
        if ($("#chart-12").length) {
            var options = {
                chart: {
                    type: 'area',
                    height: 100,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false,
                    },
                },

                stroke: {
                    colors: [colors[2]],
                    curve: 'straight',
                    width: 3
                },
                fill: {
                    opacity: 0.7,
                    gradient: {
                        enabled: false
                    }
                },
                series: [{
                    data: @json($chart_monthly)
                }],
                yaxis: {
                    min: 0
                },
                colors: colors[2],

            }
            var chart = new ApexCharts(
                document.querySelector("#chart-12"),
                options
            );

            chart.render();
        }
        if ($("#chart-13").length) {
            var options = {
                chart: {
                    type: 'area',
                    height: 100,
                    sparkline: {
                        enabled: true
                    },
                    animations: {
                        enabled: false,
                    },
                },

                stroke: {
                    colors: [colors[3]],
                    curve: 'straight',
                    width: 3
                },
                fill: {
                    opacity: 0.7,
                    gradient: {
                        enabled: false
                    }
                },
                series: [{
                    data: @json($chart_daily)
                }],
                yaxis: {
                    min: 0
                },
                colors: colors[3],

            }
            var chart = new ApexCharts(
                document.querySelector("#chart-13"),
                options
            );

            chart.render();
        }
    })
</script>
<!--chart data for current dashboard-->
@endsection
