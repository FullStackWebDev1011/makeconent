@extends('layouts.main')
@section('content')
    <section class="admin-content">
        <div class="container-fluid bg-dark m-b-30">
            <div class="row">

                <div class="col-9 text-white p-t-40 p-b-90">
                    <h4 class="  ">
                        <span class="btn btn-white-translucent">
                            <i class="mdi mdi-shape-circle-plus"></i>
                        </span>
                        {{__('main.good_afternoon')}}, {{Auth::user()->fullname}}!</h4>
                    <p class="opacity-75">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad corporis dolores <br> doloribus
                        esse et iste laboriosam maiores maxime, mollitia nisi numquam omnis praesentium provident quam
                        quasi quia quisquam recusandae vel.
                    </p>
                    <a href="{{ route('projects.browse') }}" class="btn btn-white-translucent">Browse Open Projects</a>
                </div>
                <div class="col-3 text-white p-t-70 p-b-90">
                    <h4>Your level is 1</h4>
                    <p class="opacity-75">Compleate 0/30 texts to level up</p>
                </div>
            </div>
        </div>
        <div class="container-fluid pull-up">
            <div class="row">
                <div class="col m-b-30">
                    <div class="card ">
                        <div class="   text-center card-body">
                            <div class="text-success   ">
                                <div class="avatar avatar-sm ">
                                    <span class="avatar-title rounded-circle badge-soft-success"><i
                                                class="mdi mdi-arrow-up-bold mdi-18px"></i> </span>

                                </div>
                                <h6 class="m-t-5 m-b-0"> {{ $earn_total ?? ($earn_today/$earn_total*100) }}%</h6>
                            </div>


                            <div class=" text-center">
                                <h3>{{ roundPrice($earn_today) }} PLN</h3>
                            </div>
                            <div class="text-overline ">
                                Earn Today
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m-b-30">
                    <div class="card ">
                        <div class="   text-center card-body">
                            <div class="text-danger   ">
                                <div class="avatar avatar-sm ">
                                    <span class="avatar-title rounded-circle badge-soft-danger"><i
                                                class="mdi mdi-arrow-down-bold mdi-18px"></i> </span>

                                </div>
                                <h6 class="m-t-5 m-b-0"> {{ $earn_total ?? ($earn_thismonth/$earn_total*100) }}%</h6>
                            </div>


                            <div class=" text-center">
                                <h3>{{ roundPrice($earn_thismonth) }} PLN</h3>
                            </div>
                            <div class="text-overline ">
                                Earn this Month
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m-b-30">
                    <div class="card ">
                        <div class="   text-center card-body">
                            <div class="text-warning   ">
                                <div class="avatar avatar-sm ">
                                    <span class="avatar-title rounded-circle badge-soft-warning"><i
                                                class="mdi mdi-arrange-send-to-back mdi-18px"></i> </span>

                                </div>
                                <h6 class="m-t-5 m-b-0"> {{ $total_projects ?? ($waiting_complete/$total_projects*100) }}
                                    %</h6>
                            </div>


                            <div class=" text-center">
                                <h3> {{ $waiting_complete }} </h3>
                            </div>
                            <div class="text-overline ">
                                Waiting to compleate
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col m-b-30">
                    <div class="card ">
                        <div class="   text-center card-body">
                            <div class="text-info   ">
                                <div class="avatar avatar-sm ">
                                    <span class="avatar-title rounded-circle badge-soft-info"><i
                                                class="mdi mdi-account-convert mdi-18px"></i> </span>

                                </div>
                                <h6 class="m-t-5 m-b-0"> {{ $total_projects ?? ($accepted_complete/$total_projects*100) }}
                                    %</h6>
                            </div>


                            <div class=" text-center">
                                <h3>{{ $accepted_complete }}</h3>
                            </div>
                            <div class="text-overline ">
                                Accepted Projects (total)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-lg-block d-none m-b-30">
                    <div class="card ">
                        <div class="   text-center card-body">
                            <div class="text-danger   ">
                                <div class="avatar avatar-sm ">
                                    <span class="avatar-title rounded-circle badge-soft-danger"><i
                                                class="mdi mdi-arrow-up-bold mdi-18px"></i> </span>

                                </div>
                                <h6 class="m-t-5 m-b-0"><i class="mdi mdi-star col-gold"></i><i
                                            class="mdi mdi-star col-gold"></i><i class="mdi mdi-star col-gold"></i><i
                                            class="mdi mdi-star"></i><i class="mdi mdi-star"></i></h6>
                            </div>


                            <div class=" text-center">
                                <h3>127</h3>
                            </div>
                            <div class="text-overline ">
                                Your Rate
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
            <div class="row ">
                <div class="col-lg-12 m-b-30">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Open Projects</div>

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
                                    <th>Project Title</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Deadline Time</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($pending_projects as $key=>$project)
                                    <tr>
                                        <td class="align-middle">

                                            <span class="ml-2">{{ $project->title }}</span></td>

                                        <td class="align-middle"><span
                                                    class="badge badge-soft-danger badge-light">{{ $project->status }}</span>
                                        </td>
                                        <td class="align-middle">{{ $project->budget }} PLN</td>
                                        <td class="align-middle"
                                            title="{{ $project->getDeadLineDate() ? userDate($project->getDeadLineDate(), true) : '' }}">
                                            {{ $project->getDeadLineDate() ? (($project->getDeadLineDate()->isPast() ? '-' : '').$project->getDeadLineDate()->diff()->format('%Hh %im')) : '' }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-primary btn-sm"
                                               href="{{ route('projects.view', ['project' => $project]) }}">
                                                View</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            No Project
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>

                        </div>
                        <div class="card-footer">
                            <div class="d-flex  justify-content-between">
                                <h6 class="m-b-0 my-auto"><span class="opacity-75"> <i class="mdi mdi-information"></i>  List based on your account orders.</span>
                                </h6>
                                <a href="#!" class="btn btn-dark">View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="col-lg-4 m-b-30 pull-right">--}}
                {{--                    <div class="card ">--}}
                {{--                        <div class="card m-b-30">--}}
                {{--                            <div class="card-header">--}}
                {{--                                <div class="card-title">Lates News</div>--}}
                {{--                            </div>--}}
                {{--                            <div class="list-group list-group-flush">--}}
                {{--                                <a href="#" class="list-group-item ">--}}
                {{--                                    <h5 class="fw-400">5 Ways to improve your writing skills</h5>--}}
                {{--                                    <small class="opacity-75">--}}
                {{--                                        Yesterday, 5.04 PM--}}
                {{--                                    </small>--}}
                {{--                                </a>--}}
                {{--                                <a href="#" class="list-group-item ">--}}
                {{--                                    <h5 class="fw-400">The Surprising Nuance Behind Art</h5>--}}
                {{--                                    <small class="opacity-75">--}}
                {{--                                        Yesterday, 10 PM--}}
                {{--                                    </small>--}}
                {{--                                </a>--}}
                {{--                                <a href="#" class="list-group-item bg-cover p-0"--}}
                {{--                                   style="background-image: url('{{url('assets/img/social/s16.jpg')}}')">--}}
                {{--                                    <div class="bg-overlay p-all-15">--}}
                {{--                                        <div class="text-white">--}}
                {{--                                            <h5 class="fw-400">Rewire your brain to beat procrastination--}}
                {{--                                            </h5>--}}
                {{--                                            <small class="opacity-75">--}}
                {{--                                                2 Days ago--}}
                {{--                                            </small>--}}
                {{--                                        </div>--}}
                {{--                                    </div>--}}
                {{--                                </a>--}}
                {{--                                <a href="#" class="list-group-item ">--}}
                {{--                                    <h5 class="fw-400">No Innovation Without Representation</h5>--}}
                {{--                                    <small class="opacity-75">--}}
                {{--                                        2 Days ago--}}
                {{--                                    </small>--}}
                {{--                                </a>--}}
                {{--                                <a href="#" class="list-group-item ">--}}
                {{--                                    <h5 class="fw-400">Innovation Isn’t About Ideas</h5>--}}
                {{--                                    <small class="opacity-75">--}}
                {{--                                        5 Days ago--}}
                {{--                                    </small>--}}
                {{--                                </a>--}}

                {{--                            </div>--}}
                {{--                            <div class="card-footer border-0 text-center">--}}
                {{--                                <a href="#">Read More</a>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}


            </div>
        </div>
    </section>
@endsection

@section('script')
    <!--Additional Page includes-->
    <script src="{{asset('assets/vendor/apexchart/apexcharts.min.js')}}"></script>
    <!--chart data for current dashboard-->
    <script src="{{asset('assets/js/dashboard-01.js')}}"></script>
@endsection

