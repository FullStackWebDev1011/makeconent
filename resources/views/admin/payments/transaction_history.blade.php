@extends('layouts.admin')

@section('title', 'Transaction History')
@section('style')
@endsection

@section('subtitle', 'Transaction History')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Transaction History</h3>

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
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $key=>$transaction)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ $transaction->user['first_name'] }} <br> <small>{{ $transaction->user['levelType'] }}</small></td>
                                        <td>{{ $transaction->type }}</td>
                                        <td class="text-capitalize">{{ $transaction->status }}</td>
                                        <td>{{ roundPrice($transaction->qty) }}</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>
                                            <a href="{{ url('members/view/'.$transaction->user['id']) }}" class="btn btn-primary" title="Block"> <span class="fas fa-eye mr-2"></span>View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Quantity</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
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