@extends('layouts.main')
@section('content')
<section class="admin-content ">
    <div class="bg-dark m-b-30">
        <div class="container">
            <div class="row p-b-60 p-t-60">

                <div class="col-md-6 text-white p-b-30">
                    <div class="media">
                        <div class="avatar avatar mr-3">

                            <span class="btn btn-white-translucent"><i class="mdi mdi-coins "></i></span>

                        </div>
                        <div class="media-body">
                            <h2>Invoices </h2>
                            <p class="opacity-75">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio ducimus facere
                                inventore molestiae nostrum odit velit.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-center m-b-30 ml-auto">
                    <div class="rounded text-white bg-white-translucent">
                        <div class="p-all-15">
                            <div class="row">
                                <div class="col-md-6 my-2 m-md-0">
                                    <div class="text-overline    opacity-75">Amount Spend (total)</div>
                                    <h3 class="m-0 text-success">{{ formatNumber($total_spend) }} PLN</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pull-up">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row m-b-20">
                                <div class="col-md-6 my-auto">
                                    <h4 class="m-0">Summary</h4>
                                </div>
                                <div class="col-md-6 text-right my-auto">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-white shadow-none js-datepicker"><i
                                                class="mdi mdi-calendar"></i> Pick Date
                                        </button>

                                        <button type="button" class="btn btn-white shadow-none">All</button>

                                    </div>

                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 p-0">

                                    <div class="table-responsive">
                                        <table class="table table-hover example">
                                            <thead class="">
                                                <tr>

                                                    <th scope="col">Date</th>
                                                    <th scope="col">Invoice Number</th>
                                                    <th scope="col">Recipient</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($invoices as $invoice)
                                                <tr>

                                                    <td class="align-middle">{{ $invoice->created_at }}</td>
                                                    <td class="align-middle">MK/{{ $invoice->id }}/{{ date('Y') }}</td>
                                                    <td class="align-middle">Me</td>
                                                    <td class="align-middle">
                                                        <span class=" text-success" style="text-transform: capitalize">
                                                            <i class="mdi mdi-check-circle "></i>
                                                            {{ $invoice->status }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <h6 class=" m-0">{{ roundPrice($invoice->qty)}} PLN</h6>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="input-group ">
                                                            <div class="input-group-prepend">
                                                                <a href="{{ route('invoice.download', ['invoice' => $invoice]) }}"
                                                                    class="btn btn-white">Download Invoice</a>
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

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@section('script')
<!--Additional Page includes-->
<script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/datatable-data.js')}}"></script>
<!--chart data for current dashboard-->
<script>
    $('.example').DataTable({
        lengthMenu: [5, 10, 25, 50],
        pageLength: 10,
        language: {
            "emptyTable": "No Transaction"
        }
    });

</script>
@endsection
