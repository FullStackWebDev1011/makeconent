@extends('layouts.admin')

@section('title', 'User Information #ID 75281')
@section('style')
    <style>
        a.nav-link {
            cursor: pointer;
        }
    </style>
@endsection

@section('subtitle', 'User Profile')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" onclick="setTab(event, 'personal')">Personal
                                        Information</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" onclick="setTab(event, 'order')">Order Manage</a></li>
                                <li class="nav-item"><a class="nav-link" onclick="setTab(event, 'waiting_withdraw')">Waiting
                                        Withdraw</a></li>
                                <li class="nav-item"><a class="nav-link" onclick="setTab(event, 'history_withdraw')">Withdraw
                                        History</a></li>
                                <li class="nav-item"><a class="nav-link" onclick="setTab(event, 'history_funds')">History
                                        of funds</a></li>
                                <li class="nav-item"><a class="nav-link" onclick="setTab(event, 'history_message')">Messange
                                        History</a></li>
                                <li class="nav-item"><a class="nav-link"
                                                        onclick="setTab(event, 'documents')">Documents</a></li>
                                <li class="nav-item"><a class="nav-link" onclick="setTab(event, 'logs')">Logs</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="personal">
                                    <!-- Post -->
                                    <div class="post col-md-12">
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box">
                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Balance</span>
                                                        <span class="info-box-number">{{ formatNumber($member->wallet?$member->wallet->total_balance:0) }} PLN</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box">

                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Earn Total</span>
                                                        <span class="info-box-number">{{ formatNumber($earn_total) }} PLN</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box">


                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Active Orders</span>
                                                        <span class="info-box-number">{{ formatNumber($active_orders) }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box">


                                                    <div class="info-box-content">
                                                        <span class="info-box-text">Compleate Orders</span>
                                                        <span class="info-box-number">{{ formatNumber($complete_orders) }}</span>
                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <div class="col-md-4 d-inline">
                                            <b>Name: </b> {{ explode(' ', $member->fullname)[0] }}<br>
                                            <b>Surename: </b> {{ explode(' ', $member->fullname)[1] ?? '' }}<br>
                                            @if($member->isCompany)
                                                <b>Company Name: </b> {{ $member->companyName}}<br>
                                                <b>Company Adress: </b> {{ $member->companyAddress}}<br>
                                                <b>Vat number: </b> {{ $member->vat_number }}<br>
                                            @else
                                                <b>Adress:</b> {{ $member->address . ' ' . $member->address_2 }}<br>
                                                <b>Bank Account: </b> {{ $member->bank_account }}<br>
                                                <b>Tax
                                                    Office: </b> {{ $member->tax_office?$member->tax_office->name:'' }}
                                                <br>
                                            @endif
                                            <b>Type: </b> {{ $member->isCompany ? 'Company' : 'Personal' }}<br>
                                            <b>Status: </b><span
                                                    class="text-capitalize">{{ $member->status }}</span><br>
                                            <b>Registration Date: </b> {{ $member->created_at }}<br>
                                        </div>
                                        <div class="row">
                                            <a type="button" href="{{ route('admin.block.user').'?id='.$member->id }}"
                                               class="btn btn-danger btn-sm mr-2">Block User</a>
                                            <button onclick="addTransaction()" type="button"
                                                    class="btn btn-primary btn-sm mr-2">Change Balance
                                            </button>
                                            <button type="button" onclick="writeMsg()"
                                                    class="btn btn-primary btn-sm mr-2">Write Messange to
                                                User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="tab-pane" id="order">--}}
                                <div class="tab-pane" id="order">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive p-t-10">
                                                        <table class="table datatable" style="width:100%">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Title</th>
                                                                <th>Category</th>
                                                                <th>Price Full</th>
                                                                <th title="Price per 1000 zzs">Rate</th>
                                                                <th>Start date</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($orders as $key=>$project)
                                                                <tr>
                                                                    <td>{{ $project->id }}</td>
                                                                    <td>{{ $project->title }}</td>
                                                                    <td>{{ $project->category->title }}</td>
                                                                    <td>{{ $project->budget }}</td>

                                                                    <td>{{ $project->rate }}</td>
                                                                    <td>{{ $project->created_at }}</td>
                                                                    <td style="text-transform: capitalize">{{ $project->status }}</td>
                                                                    <td>
                                                                        <button class="btn btn-primary btn-sm">
                                                                            View Text
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6">
                                                                        No Orders
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
                                <div class="tab-pane" id="waiting_withdraw">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive p-t-10">
                                                        <table class="table table-hover datatable">
                                                            <thead class="">
                                                            <tr>
                                                                <th scope="col">ID #</th>
                                                                <th scope="col">Date</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Ammount</th>
                                                                <th scope="col">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($waiting_withdrawals as $transaction)
                                                                <tr>
                                                                    <td class="align-middle">
                                                                        #{{$transaction->id}}
                                                                    </td>
                                                                    <td class="align-middle">{{ $transaction->created_at }}
                                                                    </td>
                                                                    <td class="align-middle">
                                                                            <span class=" text-success">
                                                                                <i class="mdi mdi-check-circle"></i> {{ $transaction->status }}</span>
                                                                    </td>
                                                                    <td class="align-middle">
                                                                        <h6 class=" m-0 text-success"> {{ $transaction->qty }}
                                                                            PLN</h6>
                                                                    </td>
                                                                    <td>
                                                                        <a class="btn btn-primary" href="#">Approve</a>
                                                                        <a class="btn btn-danger" href="#">Cancel</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="history_withdraw">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row ">
                                                        <div class="col-md-12 p-0">

                                                            <div class="table-responsive">
                                                                <table class="table table-hover datatable">
                                                                    <thead class="">
                                                                    <tr>
                                                                        <th scope="col">ID #</th>
                                                                        <th scope="col">Date</th>
                                                                        <th scope="col">Status</th>
                                                                        <th scope="col">Ammount</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($history_withdrawals as $transaction)
                                                                        <tr>
                                                                            <td class="align-middle">
                                                                                #{{$transaction->id}}
                                                                            </td>
                                                                            <td class="align-middle">{{ $transaction->created_at }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                            <span class=" text-success">
                                                                                <i class="mdi mdi-check-circle"></i> {{ $transaction->status }}</span>
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                <h6 class=" m-0 text-success"> {{ roundPrice($transaction->qty) }}
                                                                                    PLN</h6>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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
                                <div class="tab-pane" id="history_funds">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row ">
                                                        <div class="col-md-12 p-0">

                                                            <div class="table-responsive">
                                                                <table class="table table-hover datatable">
                                                                    <thead class="">
                                                                    <tr>
                                                                        <th scope="col">ID #</th>
                                                                        <th scope="col">Date</th>
                                                                        <th scope="col">Type</th>
                                                                        <th scope="col">Ammount</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($history_withdrawals as $transaction)
                                                                        <tr>
                                                                            <td class="align-middle">
                                                                                #{{$transaction->id}}
                                                                            </td>
                                                                            <td class="align-middle">{{ $transaction->created_at }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                            <span class="text-capitalize text-success">
                                                                                {{ $transaction->type }}</span>
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                <h6 class=" m-0 text-success"> {{ roundPrice($transaction->qty) }}
                                                                                    PLN</h6>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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
                                <div class="tab-pane" id="history_message">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row ">
                                                        <div class="col-md-12 p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover datatable">
                                                                    <thead class="">
                                                                    <tr>
                                                                        <th scope="col">ID #</th>
                                                                        <th scope="col">Date</th>
                                                                        <th scope="col">Type</th>
                                                                        <th scope="col">Text</th>
                                                                        <th scope="col">Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($messages as $key=>$message)
                                                                        <tr>
                                                                            <td class="align-middle">
                                                                                #{{$key + 1}}
                                                                            </td>
                                                                            <td class="align-middle">{{ $message->created_at }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                {{ $member->id === $message->sender ? 'Sent' : 'Received' }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                {{ $message->text }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                <button class="btn btn-danger"><span
                                                                                            class="fa fa-trash"></span>
                                                                                </button>
                                                                                <button class="btn btn-primary"><span
                                                                                            class="fa fa-eye"></span>
                                                                                </button>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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
                                <div class="tab-pane" id="documents">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row m-b-20">
                                                        <div class="col-md-6 my-auto">
                                                            <h4 class="m-0">Summary</h4>
                                                        </div>
                                                        <div class="col-md-6 text-right my-auto">
                                                            <div class="btn-group" role="group"
                                                                 aria-label="Basic example">
                                                                <button type="button"
                                                                        class="btn btn-white shadow-none js-datepicker">
                                                                    <i class="mdi mdi-calendar"></i> Pick Date
                                                                </button>
                                                                <button type="button" class="btn btn-white shadow-none">
                                                                    All
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row ">
                                                        <div class="col-md-12 p-0">

                                                            <div class="table-responsive">
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
                                                                    @forelse($documents as $key=>$document)
                                                                        <tr>
                                                                            <td class="align-middle">
                                                                                {{ $key + 1 }}
                                                                            </td>
                                                                            <td class="align-middle">{{ $document->created_at }}</td>
                                                                            <td class="align-middle">
                                                                                #{{ $document->bill_number }}</td>
                                                                            <td class="align-middle">Me</td>
                                                                            <td class="align-middle">
                                                                                <span class=" text-success" style="text-transform: capitalize">
                                                                                    <i class="mdi mdi-check-circle "></i> {{ $document->status }}</span>
                                                                            </td>
                                                                            <td class="align-middle"><h6 class=" m-0">
                                                                                    ${{ $document->qty }}</h6></td>
                                                                            <td class="align-middle">
                                                                                <div class="input-group ">
                                                                                    <div class="input-group-prepend">
                                                                                        <a href="{{ route('document.download', ['document' => $document]) }}"
                                                                                           class="btn btn-white">Download
                                                                                            Invoice</a>
                                                                                    </div>

                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="7" class="text-center">No
                                                                                document
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
                                <div class="tab-pane" id="logs">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row ">
                                                        <div class="col-md-12 p-0">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover datatable">
                                                                    <thead class="">
                                                                    <tr>
                                                                        <th scope="col">ID #</th>
                                                                        <th scope="col">Date</th>
                                                                        <th scope="col">IP</th>
                                                                        <th scope="col">Browser</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($logs as $key=>$log)
                                                                        <tr>
                                                                            <td class="align-middle">
                                                                                #{{$key + 1}}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                {{ $log->created_at }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                {{ $log->ip }}
                                                                            </td>
                                                                            <td class="align-middle">
                                                                                {{ $log->agent }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
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
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    @include('modals.admin_add_transaction')
    @include('modals.admin_user_balance')
    @include('modals.admin_message')
@endsection

@section('script')
    <script>
        $(function () {
            $('.datatable').DataTable();

            @if(session()->has('success'))
            $.notify({
                // options
                title: 'Successfully',
                message: ''
            }, {
                placement: {
                    align: "right",
                    from: "bottom"
                },
                timer: 500,
                // settings
                type: 'success',
            });
            @endif

        });

        function setTab(event, tabName) {
            $('.nav-link').removeClass('active');
            $(event.target).addClass('active');
            $('.tab-pane').removeClass('active');
            $('#' + tabName).addClass('active');
        }

        function changeBalance() {
            $('#admin_balance_modal').modal('show');
        }
        function addTransaction() {
            $('#admin_add_transaction').modal('show');
        }

        function writeMsg() {
            $('#message_modal').modal('show');
        }
    </script>
@endsection