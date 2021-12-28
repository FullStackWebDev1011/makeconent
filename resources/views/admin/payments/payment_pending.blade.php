@extends('layouts.admin')

@section('title', 'Payment To Accept')
@section('style')
@endsection

@section('subtitle', 'Payment To Accept')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Payment To Accept</h3>

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
                            <table class="example table" style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>PLN Pay</th>
                                    <th>Type</th>
                                    <th>Account</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $key=>$transaction)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{ $transaction->qty }}</td>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ $transaction->user->isCompany ? 'Personal' : 'Buissness' }}</td>
                                        <td>Pending</td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td class="invoice_id_{{ $transaction->id }}">
                                            <button onclick="openModal('{{ $transaction->id }}')"
                                                    data-invoice-type="{{ $transaction->type }}"
                                                    data-invoice-account="{{ $transaction->user->isCompany ? 'Personal' : 'Buissness' }}"
                                                    data-invoice-email="{{ $transaction->user->email }}"
                                                    data-invoice-address="{{ $transaction->user->getAddress() }}"
                                                    data-invoice-bank-account="{{ $transaction->user->bank_account }}"
                                                    data-url="{{ route('admin.withdrawal.approve', ['id' => $transaction->id]) }}"
                                                    class="btn btn-primary text-white js_invoice_data"><span class="fa fa-eye"></span>
                                                View
                                            </button>
                                            {{--<a class="btn btn-danger  text-white">Cancel</a>--}}
                                        </td>
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
        @include('modals.admin_payment_modal')
    </section>
@endsection

@section('script')
    <script>
        $(function () {
            $('.example').DataTable();
        });

        function openModal(id) {
            $('#admin_payment_modal').modal('show');
            $('#admin_payment_modal .js_invoice_id').text(id);
            $('#admin_payment_modal .js_invoice_type').text($('.invoice_id_' + id + ' .js_invoice_data').attr('data-invoice-account'));
            $('#admin_payment_modal .js_invoice_email').text($('.invoice_id_' + id + ' .js_invoice_data').attr('data-invoice-email'));
            $('#admin_payment_modal .js_invoice_address').text($('.invoice_id_' + id + ' .js_invoice_data').attr('data-invoice-address'));
            $('#admin_payment_modal .js_invoice_bank_account').text($('.invoice_id_' + id + ' .js_invoice_data').attr('data-invoice-bank-account'));
        }
    </script>
@endsection