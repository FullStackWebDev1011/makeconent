@extends('layouts.main')
@section('content')
    <section class="admin-content">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-8 m-auto text-white p-b-30">

                        <h2> Open Projects</h2>
                        <p class="opacity-75">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At autem corporis dicta
                            dignissimos earum ex facere fuga, impedit itaque minima nisi numquam officiis quisquam sequi
                            sint sit sunt tempora voluptate
                        </p>
                    </div>
                    <div class="col-md-4 m-auto text-white p-b-30">
                        <div class="text-md-right">
                            <a href="{{ route('projects.new') }}" class="btn btn-success"> <i class="mdi mdi-plus"></i>
                                New Project</a>
                        </div>
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
                                <table id="open" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Price Full</th>
                                        <th title="Price per 1000 zzs">Rate</th>
                                        <th>Start date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($projects as $key=>$project)
                                        <tr>
                                            <td>#{{ $project->id }}</td>
                                            <td>{{ $project->title }}</td>
                                            <td>{{ $project->category->title }}</td>
                                            <td>{{ $project->budget }} PLN</td>
                                            {{--                                        <td>{{ $project->quality ? $project->category[$project->quality . '_min'] : $project->rate }}</td>--}}
                                            <td>{{ $project->rate }} PLN <small> /100 words</small></td>
                                            <td>{{ $project->created_at }}</td>
                                            <td class="text-capitalize {{$project->status}}">{{ $project->status }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                   href="{{ route('projects.view', ['project' => $project]) }}">
                                                    View</a></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                No Open Orders
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Price Full</th>
                                        <th title="Price per 1000 zzs">Rate</th>
                                        <th>Start date</th>
                                        <th>Status</th>
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
            $('#open').DataTable({
                ordering: true
            });
            @if(session()->has('payment_success'))
            $.notify({
                // options
                title: 'Successfully',
                message: 'Project created.'
            }, {
                placement: {
                    align: "right",
                    from: "bottom"
                },
                timer: 500,
                // settings
                type: 'success',
            });
            @endif
        });
    </script>
@endsection

