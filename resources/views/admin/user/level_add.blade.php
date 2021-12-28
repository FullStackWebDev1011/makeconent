@extends('layouts.admin')

@section('title', 'Level User')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('subtitle', 'Edit Level User')

@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <form method="POST" action="{{ route('admin.level.save')}}">
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
                <div class="col-md-12">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputName">Name <span class="text-red">*</span></label>
                                        <input type="text" name="name" id="inputName" class="form-control"
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescription">Description</label>
                                        <textarea id="inputDescription" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Menu Role <span class="text-red">*</span></label>
                                        <div class="select2-info" id="mrMenuRole">
                                            <select class="select2" name="menu_role[]" multiple="multiple"
                                                data-placeholder="Select a Menu" data-dropdown-css-class="select2-info"
                                                style="width: 100%;">
                                                @foreach($mrMenuRole as $key=>$value)
                                                    <option value="{{$key}}">{{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputLevelType">Level Type <span class="text-red">*</span></label>
                                        <select class="form-control custom-select" name="levelType">
                                            <option value="client"> Client </option>
                                            <option value="copywriter"> Copywriter </option>
                                            <option value="support"> Support </option>
                                            <option value="admin"> Admin </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputStatus">Status <span class="text-red">*</span></label>
                                        <select class="form-control custom-select" name="status">
                                            <option value="active"> Active </option>
                                            <option value="inactive"> Inactive </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{url()->previous()}}" class="btn btn-secondary">Cancel</a>
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
