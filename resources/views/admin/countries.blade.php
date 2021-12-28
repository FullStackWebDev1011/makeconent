@extends('layouts.admin')

@section('title', 'Countries')
@section('style')
@endsection

@section('subtitle', 'Countries')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Countries</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <div class="text-right"> <button class="btn btn-outline-primary" onclick="openAddModal()">Add</button></div>
                            <table id="usersTable" class="table table-hover text-nowrap projects">
                                <thead>
                                <tr>
                                    <th style="width: 5%"> # </th>
                                    <th style="width: 20%"> Name </th>
                                    <th style="width: 15%">Action</th>
									<th style="width: 15%">Active for Copy</th>
									<th style="width: 15%">Active for User</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($countries as $key=>$country)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $country->name }}</td>
                                        <td>{{ $country->currency }}</td>
										<td>Yes</td>
										<td>Yes</td>
                                        <td>
                                            <button class="btn btn-primary" onclick="editCountry('{{ $country->id }}')">Edit</button>
                                            <button class="btn btn-danger" onclick="delCountry('{{ $country->id }}')">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
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
    <div id="modal_block">
        @include('modals.admin_tax_modal')
    </div>
@endsection

@section('script')
    <script>
        $(function () {
            $("#usersTable").DataTable();
        });
        
        function openAddModal() {
            $('input[name="id"]').val('');
            $('input[name="name"]').val('');
            $('input[name="currency"]').val('');
            $('#tax_modal').modal('show');
        }

        function editCountry(id) {
            $.get('{{ route('countries.get') }}' + '?id=' + id, function (res) {
                $('#modal_block').html(res);
                $('#tax_modal').modal('show');
            })
        }

        function delCountry(id) {
            if(confirm('Are you sure to delete this countries?')) {
                $.get('{{ route('countries.delete') }}' + '?id=' + id, function () {
                    location.reload();
                });
            }
        }
    </script>
@endsection