@extends('layouts.admin')

@section('title', 'Bonus Code')
@section('style')
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if($errors->has('code'))
                    <div class="alert alert-danger col-md-12">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bonus Code</h3>

                            
                        </div>
                        <div class="card-body table-responsive p-1">
                            <div class="text-right">
                                <button type="button" class="btn btn-outline-primary" onclick="openAddModal()">+ Add
                                </button>
                            </div>
                            <table id="projectTable" class="table table-hover text-nowrap projects">
                                <thead>
                                <tr>
                                    <th style="width: 5%"> # </th>
                                    <th style="width: 20%"> Code </th>
                                    <th style="width: 20%"> Type </th>
                                    <th style="width: 20%"> Status </th>
					                <th style="width: 15%">Use Count</th> <th style="width: 15%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($bonus_codes as $key=>$code)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $code->code }}</td>
                                        <td>{{ ucfirst($code->type) }}</td>
                                        <td><span class="text-capitalize">{{ $code->status }}</span></td>
						                <td><span class="text-capitalize"> {{ $code->counting }} </span></td>				
                                        <td>
                                            <button class="btn btn-danger" onclick="delCode('{{ $code->id }}')">Disactive</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No code
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
    <div id="modal_block">
        @include('modals.admin_bonus_code_modal')
    </div>

    <!-- /.content -->
@endsection

@section('script')
    <script>
        $(function () {

        });
        function openAddModal() {
            $('#bonus_code_modal').modal('show');
        }

        function delCode(id) {
            if (confirm('Are you sure to delete this code?')) {
                $.get('{{ route('bonus-code.delete') }}' + '?id=' + id, function () {
                    location.reload();
                });
            }
        }

        function generate() {
            var src = "ABCDEFGHIGKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            var ret = "";
            for(var i = 0; i<20; i++) {
                ret += src[Math.floor(Math.random() * 62) % 62 ];
            }
            $('input[name="code"]').val(ret);
        }
    </script>
@endsection