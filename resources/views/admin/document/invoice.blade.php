@extends('layouts.admin')

@section('title', 'Client Invoices')
@section('style')
@endsection

@section('subtitle', 'Client Invoices')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Invoices</h3>
                            <div class="form-row">
                                <div class="col-md-6 mb-6">
                                    <input type="text" class="js-datepicker form-control" value="{{ now()->subMonth()->format('Y-m-d') }} - {{ now()->format('Y-m-d') }}" placeholder="Select a Date">
                                </div>
                                <div class="col-md-6 mb-6">
                                    <form method="post" action="{{ route('admin.invoices.download.bulk') }}">
                                        @csrf
                                        <input type="hidden" name="start_date" value="{{ now()->subMonth()->format('Y-m-d') }}">
                                        <input type="hidden" name="end_date" value="{{ now()->format('Y-m-d') }}">
                                        <button type="submit" class="btn btn-info">Download bulk PDFs</button>
                                    </form>
                                </div>
                            </div>

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
                            <table class="table table-hover example">
                                <thead class="">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invoice Number</th>
                                    <th scope="col">Recipient</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($invoices as $key => $invoice)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="align-middle">{{ $invoice->created_at }}</td>
                                        <td class="align-middle">MK/{{ $invoice->id }}/{{date('Y')}}</td>
                                        <td class="align-middle">Me</td>
                                        <td class="align-middle">
                                                        <span class=" text-success" style="text-transform: capitalize">
                                                            <i class="mdi mdi-check-circle "></i> {{ $invoice->status }}</span>
                                        </td>
                                        <td class="align-middle"><h6 class=" m-0">{{ $invoice->qty }} PLN</h6></td>
                                        <td class="align-middle">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <a href="{{ route('invoice.download', ['invoice' => $invoice]) }}"
                                                       class="btn btn-default">Download Invoice</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            No Invoice
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
    </script>
@endsection