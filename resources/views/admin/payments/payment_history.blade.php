@extends('layouts.admin')

@section('title', 'Payment History')
@section('style')
@endsection

@section('subtitle', 'Payment History')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Payment History</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="example table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Quantity</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    {{--<th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $key=>$transaction)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ $transaction->qty }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td class="text-capitalize">{{ $transaction->status }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Quantity</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    {{--<th>Action</th>--}}
                                </tr>
                                </tfoot>
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
            $('.example').DataTable();
        });
    </script>
@endsection