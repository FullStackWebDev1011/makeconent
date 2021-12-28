@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Dashboard')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{ $orders_today }}</h3>

                            <p>Orders Today</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{ roundPrice($earns_today) }} <sup style="font-size: 20px">PLN</sup></h3>

                            <p>Earn Today</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{ roundPrice($earns_total) }} <sup style="font-size: 20px">PLN</sup></h3>

                            <p>Earn Total</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{ $users + $copywriters }}</h3>
                            <p>Total users + copywriter</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>

                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Sales</h3>
                        <a href="javascript:void(0);">View Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg">18,230.00 PLN</span>
                            <span>Sales Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                      <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                            <span class="text-muted">Since last month</span>
                        </p>
                    </div>
                    <!-- /.d-flex -->

                    <div class="position-relative mb-4">
                        <canvas id="sales-chart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                  </span>

                        <span>
                    <i class="fas fa-square text-gray"></i> Last year
                  </span>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Development docs</h3>
                    </div>
                </div>
                <div class="card-body">
                    <h2>Cron jobs</h2>
                    <p>Should be added to cron job task list</p>
                    <code>* * * * * cd {{ base_path() }} && php artisan schedule:run >> /dev/null 2>&1</code>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script src="/js/Chart.min.js"></script>
    <!-- <script src="/js/dashboard3.js"></script> -->
    <script>
        $(function(){
            'use strict'

            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode      = 'index'
            var intersect = true

            var $salesChart = $('#sales-chart')
            
            var salesChart  = new Chart($salesChart, {
                type   : 'bar',
                data   : {
                labels  : ['JAN','FEB','MARCH', 'APRIL', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                datasets: [
                        {
                            backgroundColor: '#007bff',
                            borderColor    : '#007bff',
                            data           : @json($sales["thisMonth"])
                        },
                        {
                            backgroundColor: '#ced4da',
                            borderColor    : '#ced4da',
                            data           : @json($sales["lastMonth"])
                        }
                    ]
                    },
                    options: {
                    maintainAspectRatio: false,
                    tooltips           : {
                        mode     : mode,
                        intersect: intersect
                    },
                    hover              : {
                        mode     : mode,
                        intersect: intersect
                    },
                    legend             : {
                        display: false
                    },
                    scales             : {
                        yAxes: [{
                        // display: false,
                        gridLines: {
                            display      : true,
                            lineWidth    : '4px',
                            color        : 'rgba(0, 0, 0, .2)',
                            zeroLineColor: 'transparent'
                        },
                        ticks    : $.extend({
                                beginAtZero: true,

                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }
                                    return '$' + value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display  : true,
                            gridLines: {
                                display: false
                            },
                            ticks    : ticksStyle
                        }]
                    }
                }
            })
        })
    </script>
@endsection