@extends('layouts.admin')

@section('title', 'User Level')
@section('style')
@endsection

@section('subtitle', 'User Level')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">User Level</h3>

                            <div class="card-tools">
                                <a href="{{ route('admin.level.get',['id'=>'add']) }}" class="btn btn-tool" data-toggle="tooltip" title="Add Level"> <i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-hover example">
                                <thead class="">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Level Type</th>
                                    <th scope="col">Create At</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($levels as $key => $level)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="align-middle">{{ $level->name }}</td>
                                        <td class="align-middle">{{ $level->levelType }}</td>
                                        <td class="align-middle">{{ $level->created_at }}</td>
                                        <td class="align-middle">
                                            @switch($level->status)
                                                @case(\App\UserLevel::STATUS_ACTIVE)
                                                <span class="text-dark"><i class="mdi mdi-watch "></i> Active</span>
                                                @break
                                                @case(\App\UserLevel::STATUS_INACTIVE)
                                                <span class="text-dark"><i class="mdi mdi-watch "></i>Inactive</span>
                                                @break
                                                @default
                                                <span class="text-dark"> {{ $level->status }}</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td class="align-middle">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <a href="{{ route( 'admin.level.get', ['id'=>$level->id] ) }}" class="btn btn-primary">Edit</a>
                                                    <button class="btn btn-danger" onclick="delUser('{{ $level->id }}')">Delete</button>
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
        });
        function delUser(id) {
            if(confirm('Are you sure to delete this user?')) {
                $.get("{{ route('admin.level.delete') }}" + "?id=" + id, function (res) {
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