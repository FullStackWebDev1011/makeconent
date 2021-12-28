@extends('layouts.main')
@section('content')
    <section class="admin-content">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-6 text-white p-b-30">
                        <div class="media">
                            <div class="avatar avatar mr-3">
                                <div class="avatar-title bg-success rounded-circle mdi mdi-currency-usd  ">

                                </div>
                            </div>
                            <div class="media-body">
                                <h1>Documents</h1>
                                <p class="opacity-75">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Distinctio ducimus facere
                                    inventore molestiae nostrum odit velit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-up">
            <div class="container-fluid">
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
                                                    <th scope="col">NO</th>
                                                    <th scope="col">Date</th>
							     <th scope="col">Type</th>					
                                                    <th scope="col">Number</th>
                                                    
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Amount Brutto</th>
							      <th scope="col">Amount Netto</th>					
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($documents as $document)
                                                <tr>
							    <td>
                                                   1
                                                    </td>
                                                    <td class="align-middle">{{ $document->created_at }}</td>
							       <td class="align-middle">Invoice/Bill</td>					
                                                    <td class="align-middle">#{{ $document->bill_number }}</td>
                                                  
                                                    <td class="align-middle">
                                                        <span class=" text-success" style="text-transform: capitalize">
                                                            <i class="mdi mdi-check-circle "></i> {{ $document->status }}</span>
                                                    </td>
                                                    <td class="align-middle"><h6 class=" m-0">{{ $document->qty }} PLN</h6></td>
							     <td class="align-middle">0,00 PLN</td>					
                                                    <td class="align-middle">
                                                        <div class="input-group ">
                                                            @if($document->attachment)
                                                            <div class="input-group-prepend">
                                                                <a href="{{ route('document.download', ['document' => $document]) }}" class="btn btn-white">Download Invoice</a>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No document</td>
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
    <script>
        $('.example').DataTable({
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {"emptyTable": "No Transaction"}
        });
    </script>
@endsection