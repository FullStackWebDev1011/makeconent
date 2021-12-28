@extends('layouts.main')
@section('content')
<section class="admin-content ">
    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-6 text-white p-b-30">
                    <div class="media">
                        <div class="avatar avatar mr-3">

                            <span class="btn btn-white-translucent"><i class="mdi mdi-coins "></i></span>

                        </div>
                        <div class="media-body">
                            <h2>All Renewals </h2>
                            <p class="opacity-75">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio ducimus facere
                                inventore molestiae nostrum odit velit.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-center m-b-30 ml-auto">
                    <div class="rounded text-white bg-white-translucent">
                        <div class="p-all-15">
                            <div class="row">
                                <div class="col-md-6 my-2 m-md-0">
                                    <div class="text-overline    opacity-75">Amount Spend (total)</div>
                                    <h3 class="m-0 text-success">{{ formatNumber($total) }} PLN</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pull-up">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-20">
                                <div class="col-md-6 my-auto">
                                    <h4 class="m-0">Summary</h4>
                                </div>
                                <div class="col-md-6 text-right my-auto">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-white shadow-none js-datepicker"><i
                                                class="mdi mdi-calendar"></i> Pick Date
                                        </button>

                                        <button type="button" class="btn btn-white shadow-none">All</button>

                                    </div>

                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 p-0">

                                    <div class="table-responsive">
                                        <table class="table table-hover example">
                                            <thead class="">
                                                <tr>

                                                    <th scope="col">Name</th>
                                                    <th scope="col">Team</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Date</th>
                                                    <!-- <th scope="col">Action</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($renewals as $renewal)
                                                <tr>

                                                    <td class="align-middle">{{ $renewal->user->first_name }}</td>
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
                                                    <td class="align-middle">{{ roundPrice($renewal->amount) }} PLN</td>
                                                    <td class="align-middle">
                                                        <span style="text-transform: capitalize">
                                                            {{ $renewal->created_at }}</span>
                                                    </td>
                                                    <!-- <td class="align-middle">
                                                        <a class="btn btn-primary btn-sm" href="#"> Connect</a>
                                                    </td> -->
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        No Renewals
                                                    </td>
                                                </tr>
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('script')
<!--Additional Page includes-->
<script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable-data.js')}}"></script>
<!--chart data for current dashboard-->
<script>
    $('.example').DataTable({
        lengthMenu: [5, 10, 25, 50],
        pageLength: 10,
        language: {
            "emptyTable": "No Transaction"
        }
    });

</script>
@endsection
