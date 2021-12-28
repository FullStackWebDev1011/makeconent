@extends('layouts.admin')

@section('title', 'Root Management')
@section('style')
@endsection

@section('subtitle', 'Root Management')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Root Management</h3>
                            <div class="form-row">
                                <div class="col-md-6 mb-6">
                                    <input type="text" class="js-datepicker form-control" value="{{ now()->subMonth()->format('Y-m-d') }} - {{ now()->format('Y-m-d') }}" placeholder="Select a Date">
                                </div>
                                <div class="col-md-6 mb-6">
                                    <form method="post" action="{{ route('admin.invoices.download.bulk') }}">
                                        @csrf
                                        <input type="hidden" name="start_date" value="{{ now()->subMonth()->format('Y-m-d') }}">
                                        <input type="hidden" name="end_date" value="{{ now()->format('Y-m-d') }}">
                                    </form>
                                </div>
                            </div>

                            <div class="card-tools">
                                <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button> -->
                                <a href="" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Add User"> <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-hover example">
                                <thead class="">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Register At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $key => $user)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="align-middle">{{ $user->fullname }}</td>
                                        <td class="align-middle">{{ $user->email }}</td>
                                        <td class="align-middle">{{ $user->created_at }}</td>
                                        <td class="align-middle">
                                            @switch($user->status)
                                                @case(\App\User::STATUS_ACTIVE)
                                                <span class="text-dark"><i class="mdi mdi-watch "></i> Active</span>
                                                @break
                                                @case(\App\User::STATUS_PENDING)
                                                <span class="text-dark"><i class="mdi mdi-watch "></i>Pending</span>
                                                @break
                                                @case(\App\User::STATUS_REJECT)
                                                <span class="text-danger"><i class="mdi mdi-close-circle "></i> Rejected</span>
                                                @break
                                                @case(\App\User::STATUS_BANNED)
                                                <span class="text-warning"><i class="mdi mdi-close-circle "></i> BANNED </span>
                                                @break
                                                @default
                                                <span class="text-dark"> {{ $user->status }}</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="align-middle">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <a href="{{ route( 'admin.root.get', ['id'=>$user->id] ) }}" class="btn btn-primary">Edit</a>
                                                    <button class="btn btn-danger" onclick="delUser('{{ $user->id }}')">Delete</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No User
                                        </td>
                                    </tr>
                                @endforelse

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $(function () {

            @if($errors->any())
                $.notify({
                    // options
                    title: 'Warning',
                    message: "{{$errors->first('error')}}"
                }, {
                    placement: {
                        align: "right",
                        from: "bottom"
                    },
                    timer: 500,
                    // settings
                    type: 'danger',
                });
            @endif

            $(".example").DataTable();
            $('.js-datepicker').daterangepicker({
                timePicker: false,
                locale: {
                    format: "YYYY-MM-DD"
                },
                singleDatePicker: false,
                showDropdowns: true,
                maxYear: parseInt(moment().format('YYYY'), 10)
            }, function (start, end, label) {

            }).on('apply.daterangepicker', function (ev, picker) {
                $('[name=start_date]').val(picker.startDate.format('YYYY-MM-DD'));
                $('[name=end_date]').val(picker.endDate.format('YYYY-MM-DD'));
            });
        });
        function delUser(id) {
            if(confirm('Are you sure to delete this user?')) {
                $.get("{{ route('admin.root.delete') }}" + "?id=" + id, function (res) {
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
                        $.notify({
                            // options
                            title: 'Success',
                            message: res.message
                        }, {
                            placement: {
                                align: "right",
                                from: "bottom"
                            },
                            timer: 500,
                            // settings
                            type: 'success',
                        });
                        setTimeout(() => { location.reload(); }, 800);
                    }
                });
            }
        }
    </script>
@endsection