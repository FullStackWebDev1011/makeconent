@extends('layouts.admin')

@section('title', 'Category Edit')
@section('style')
@endsection

@section('subtitle', 'Category')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Categories</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"
                                        data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <div class="text-right">
                                <button class="btn btn-outline-primary" onclick="openAddModal()">Add
                                </button>
                            </div>
                            <table id="projectTable" class="table table-hover text-nowrap projects">
                                <thead>
                                <tr>
                                    <th style="width: 5%">
                                        #
                                    </th>
                                    <th style="width: 20%">
                                        Title
                                    </th>
                                    <th style="width: 10%">
                                        Currency
                                    </th>
                                    <th style="width: 10%">
                                        Q1(min)
                                    </th>
                                    <th style="width: 10%">
                                        Q1(max)
                                    </th>

                                    <th style="width: 10%">
                                        Q2(min)
                                    </th>
                                    <th style="width: 10%">
                                        Q2(max)
                                    </th>

                                    <th style="width: 10%">
                                        Q3(min)
                                    </th>
                                    <th style="width: 10%">
                                        Q3(max)
                                    </th>
                                    <th style="width: 15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $key=>$cat)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $cat->title }}</td>
                                        <td>{{ strtoupper($cat->currency) }}</td>
                                        <td>{{ $cat->q1_min }}</td>
                                        <td>{{ $cat->q1_max }}</td>
                                        <td>{{ $cat->q2_min }}</td>
                                        <td>{{ $cat->q2_max }}</td>
                                        <td>{{ $cat->q3_min }}</td>
                                        <td>{{ $cat->q3_max }}</td>
                                        <td>
                                            <button class="btn btn-primary"
                                                    onclick="editCategory('{{ $cat->id }}')">Edit
                                            </button>
                                            <button class="btn btn-danger" onclick="delCategory('{{ $cat->id }}')">
                                                Delete
                                            </button>
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
        @include('modals.admin_category_modal')
    </div>

    <!-- /.content -->
@endsection

@section('script')
    <script>
        function openAddModal() {
            $('#category_modal').modal('show');
        }

        function editCategory(id) {
            $.get('{{ route('category.get') }}' + '?id=' + id, function (res) {
                $('#modal_block').html(res);
                $('#category_modal').modal('show');
            })
        }

        function delCategory(id) {
            if (confirm('Are you sure to delete this category?')) {
                $.get('{{ route('category.delete') }}' + '?id=' + id, function () {
                    location.reload();
                });
            }
        }
    </script>
@endsection