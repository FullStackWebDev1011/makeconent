@extends('layouts.main')

@section('style')
    <style>
        .row {
            margin: 0 !important;
        }
    </style>
@endsection

@section('content')
    <section class="admin-content">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-12 m-auto text-white p-b-30">
                        <h2><span class="btn btn-white-translucent"><i class="mdi mdi-format-color-text "></i></span>
                            Acctual project</h2>
                        <p class="opacity-75">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At autem corporis dicta
                            dignissimos earum ex facere fuga, impedit itaque minima nisi numquam officiis quisquam sequi
                            sint sit sunt tempora voluptate
                        </p>


                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid pull-up">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-t-10">
                                <table id="example" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Price Full</th>
                                        <th>Status</th>
                                        <th title="Price per 1000 zzs">Rate</th>
                                        <th>Start date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $key=>$project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->title }}</td>
                                            <td>{{ $project->category->title }}</td>
                                            <td>{{ $project->budget }} PLN</td>
                                            {{--                                            <td>{{ $project->quality ? $project->category[$project->quality . '_min'] : $project->rate }}</td>--}}
                                            <td>
                                                @switch($project->status)
                                                    @case(\App\Project::STATUS_PENDING)
                                                    <span class="text-dark"><i
                                                                class="mdi mdi-watch "></i> Pending</span>
                                                    @break
                                                    @case(\App\Project::STATUS_CHECKING_PLAGIARISM)
                                                    <span class="text-dark"><i
                                                                class="mdi mdi-watch "></i> Checking plagiarism</span>
                                                    @break
                                                    @case(\App\Project::STATUS_REJECTED)
                                                    <span class="text-danger"><i
                                                                class="mdi mdi-close-circle "></i> {{ $project->status }}</span>
                                                    @break
                                                    @case(\App\Project::STATUS_AMENDMENT)
                                                    <span class="text-warning"><i
                                                                class="mdi mdi-close-circle "></i> {{ $project->status }}</span>
                                                    @break
                                                    @case(\App\Project::STATUS_WRITTEN)
                                                    <span class="text-dark"><i
                                                                class="mdi mdi-check-circle "></i> {{ $project->status }}</span>
                                                    @break
                                                    @case(\App\Project::STATUS_ACCEPTED)
                                                    <span class="text-success"><i
                                                                class="mdi mdi-check-circle "></i> Accepted</span>
                                                    @break
                                                    @default
                                                    <span class="text-dark"> {{ $project->status }}</span>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>{{ $project->rate }} PLN <small> /100 words</small></td>
                                            <td>{{ $project->created_at }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                   href="{{ route('projects.view', ['project' => $project]) }}">
                                                    View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Price Full</th>
                                        <th>Status</th>
                                        <th title="Price per 1000 zzs">Rate</th>
                                        <th>Start date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
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
        $(function () {
            $('#history').DataTable({
                ordering: true
            });
        });
    </script>
@endsection

