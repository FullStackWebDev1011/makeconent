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
                                <i class="mdi mdi-format-text "></i></span> Order # {{$project->id}}
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
                    <!--widget card begin-->
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="m-b-0">
                                {{ $project->title }}
                            </h5>
                            <div class="text-md-right">
                                <span class=" badge badge-soft-primary"> {{$project->status}}</span>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="col-md-12">
                                <h4>Description:</h4>
                                <p>{{ $project->description }}</p>
                            </div>

                            <div class="col-md-12 row">
                                <div class="col-md-3">
                                    <h5 > Text Lenght: <br><span class="text-muted ml-3 small">{{ $project->min_chars }} ZZS</span>
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 > Price: <br><span class="text-muted ml-3 small">{{ $project->budget }} PLN</span>
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="mt-0 mb-1"> Need Bold Keywords?: <br><span class="text-muted ml-3 small">
                                            {{ $project->cp_bold_keyword == 1?'Yes':'No' }}
                                        </span>
                                    </h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="mt-0 mb-1"> Need Text Tittle?: <br><span class="text-muted ml-3 small">
                                            {{ $project->cp_write_title == 1?'Yes':'No' }}
                                        </span>
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-md-12 m-b-30">
                    <h5>Order text's</h5>
                    <div class="table-responsive">
                        <table class="table align-td-middle table-card">
                            <thead>
                            <tr>
                                <th>Copywriter</th>
                                <th>Title</th>
                                <th>Status</th>
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
                                                    {{ $project->seller->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Title For Text</td>
                                    <td><span class="badge badge-soft-success">{{ $project->status }}</span></td>


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

    </section>
@endsection

@section('script')
    <script>
        var orderId = '{{$project->id}}';
        function pay(){
            $.get('{{ route('project.pay') }}' + '?id=' + orderId, function (res) {
                if(res.status === false) {
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
                }else{
                    location.reload();
                }
            });
        }

        function changePrice(){

        }

        function cancelOrder() {
            $.get('{{route('project.cancel')}}' + '?id=' + orderId, function (res) {
                console.log(res);
                if(res.status === false) {
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
                }else{
                    location.reload();
                }
            })
        }
    </script>
@endsection