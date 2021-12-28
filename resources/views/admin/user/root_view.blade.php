@extends('layouts.admin')

@section('title', 'Root Management')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('subtitle', 'Edit Root Management')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="POST" action="{{ route('admin.root.save')}}">
            <div class="row">
                <div class="mx-auto col-md-12">
                    @if ($errors->any())
                        <div class="col-12 alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Basic Data</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            @csrf
                            <input type="hidden" value="{{$user->id}}" name="id">
                            <div class="form-group">
                                <label for="inputFirstName">First Name <span class="text-red">*</span></label>
                                <input type="text" name="first_name" id="inputFirstName" class="form-control"
                                    value="{{ old('first_name') ?? $user->first_name }}">
                            </div>
                            <div class="form-group">
                                <label for="inputLastName">Last Name <span class="text-red">*</span></label>
                                <input type="text" name="last_name" id="inputLastName" class="form-control"
                                    value="{{ old('last_name') ?? $user->last_name }}">
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Email <span class="text-red">*</span></label>
                                <input type="email" name="email" id="inputEmail" class="form-control"
                                    value="{{ old('email') ?? $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Password</label>
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                    value="{{ old('password') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Status <span class="text-red">*</span></label>
                                <select class="form-control custom-select" name="status">
                                    <option value="active" {{ $user->status == 'active' ? 'selected' : ''}}>Active
                                    </option>
                                    <option value="pending" {{ $user->status == 'pending' ? 'selected' : ''}}>Pending
                                    </option>
                                    <option value="reject" {{ $user->status == 'reject' ? 'selected' : ''}}>Reject
                                    </option>
                                    <option value="banned" {{ $user->status == 'banned' ? 'selected' : ''}}>Banned
                                    </option>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Level Access</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputStatus">Level <span class="text-red">*</span></label>
                                <select class="form-control custom-select" name="level_id">
                                    @foreach($mrLevel as $level)
                                    <option value="{{$level->id}}" {{ $user->level_id == $level->id ? 'selected' : ''}}>{{$level->name}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <a href="#" class="btn btn-secondary">Cancel</a>
                    <input type="submit" value="Save Changes" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@section('script')
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

</script>
@endsection
