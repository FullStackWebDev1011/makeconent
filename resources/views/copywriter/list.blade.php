@extends('layouts.main')
@section('content')
    <section class="admin-content " id="contact-search">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-6 text-center mx-auto text-white p-b-30">
                        <div class="m-b-10">
                            <div class="avatar ">
                                <div class="avatar-title rounded-circle mdi mdi-contacts "></div>
                            </div>
                        </div>
                        <h3>Contacts </h3>
                        <div class="form-dark">
                            <div class="input-group input-group-flush mb-3">
                                <input placeholder="Search Contacts" type="search"
                                       class="form-control form-control-lg search form-control-prepended">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="mdi mdi-magnify"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
        <section class="pull-up">
            <div class="container">
                <div class="row list">
                    @forelse($copywriters as $key=>$copywriter)
                        <div class="col-lg-4 col-md-6">
                            <div class="card m-b-30">
                                <div class="card-header">

                                    <div class="card-controls">
                                        <a class="badge badge-soft-info" href="#">Financial, Banking</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div>
                                            <div class="avatar avatar-xl avatar-dnd">
                                                @if($copywriter->avatar)
                                                    <img class="avatar-img rounded-circle"
                                                         src="{{asset($copywriter->avatar)}}"
                                                         alt="name">
                                                @else
                                                    <img class="avatar-img rounded-circle"
                                                         src="/assets/img/users/avatar.png"
                                                         alt="name">
                                                @endif
                                            </div>
                                        </div>
                                        <h3 class="p-t-10 searchBy-name">{{ $copywriter->fullname ?? '' }}</h3>
                                    </div>
                                    <div class="text-muted text-center m-b-10">
                                        <span class=" text-success"><i class="mdi mdi-check-circle "></i> {{ $copywriter->rate_positive ?? '0' }} </span>
                                        <b>/</b>
                                        <span class=" text-danger"><i class="mdi mdi-close-circle "></i> {{ $copywriter->rate_negative ?? '0' }} </span>
                                    </div>


                                    <p class="text-muted text-center">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium amet at
                                        odio quod rem rerum temporibus veniam vero.
                                    </p>
                                    <div class="row text-center p-b-10">
                                        <div class="col">
                                            <a href="#">
                                                <h3 class="mdi mdi-check-all"></h3>
                                                <div class="text-overline">Hire IT</div>

                                            </a>

                                        </div>
                                        <div class="col">
                                            <a href="{{ route('profile', ['user' => $copywriter]) }}">
                                                <h3 class="mdi mdi-account-group"></h3>
                                                <div class="text-overline">View Profile</div>

                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            No Copywriters
                        </div>
                    @endforelse
                </div>
            </div>

        </section>
    </section>
@endsection

@section('script')
    <!--Additional Page includes-->
    <script src="{{asset('assets/vendor/apexchart/apexcharts.min.js')}}"></script>
    <!--chart data for current dashboard-->
@endsection

