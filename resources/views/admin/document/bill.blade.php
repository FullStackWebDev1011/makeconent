@extends('layouts.admin')

@section('title', 'Copywriter Bills')
@section('style')
@endsection

@section('subtitle', 'Copywriter Bills')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bills</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-hover example">
                                <thead class="">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Invoice/Bill Number</th>
                                    <th scope="col">Recipient</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($documents as $key => $document)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="align-middle">{{ $document->created_at }}</td>
                                        <td class="align-middle">#{{ $document->bill_number }}</td>
                                        <td class="align-middle">Me</td>
                                        <td class="align-middle">
                                                        <span class=" text-success" style="text-transform: capitalize">
                                                            <i class="mdi mdi-check-circle "></i> {{ $document->status }}</span>
                                        </td>
                                        <td class="align-middle"><h6 class=" m-0">${{ $document->qty }}</h6></td>
                                        <td class="align-middle">
                                            <div class="input-group ">
                                                <div class="input-group-prepend">
                                                    <a href="{{ route('document.download', ['document' => $document]) }}" class="btn btn-default">Download Bill</a>
                                                </div>

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