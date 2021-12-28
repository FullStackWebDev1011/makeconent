@extends('layouts.admin')

@section('title', 'Copywriters')

@section('style')

@endsection

@section('subtitle', 'Copywriters')

@section('content')
    @if(session()->has('success'))
        <div class="alert alert-success">
            Success! {{ session()->get('success') }}
        </div>
    @endif
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><span class="fas fa-user-edit mr-2"></span>Copywriters</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-1">
                            <table id="copywriterTable" class="table table-hover text-nowrap projects">
                                <colgroup>
                                    <col style="width: 10%">
                                    <col style="width: 20%">
                                    <col style="width: 20%">
                                    <col style="width: 10%">
                                    <col style="width: 30%">
                                    <col style="width: 10%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Reason</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key=>$user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <ul class="list-inline v-center">
                                                <li class="list-inline-item">
                                                    <img alt="Avatar" class="table-avatar"
                                                         src="{{asset($user->avatar?$user->avatar:'assets/img/users/avatar.png')}}">
                                                </li>
                                                <li class="list-inline-item">
                                                    {{ $user->fullname }}<br/>
                                                    <small>{{ $user->email }}</small>
                                                </li>
                                            </ul>

                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td><span class="tag tag-status">{{ $user->status }}</span></td>
                                        <td>{{ substr($user->request_string, 0, 30) . '...' }}
                                            <a onclick="showDetail('{{$user->request_string}}')" class="p-2 btn btn-flat" style="float: right;text-decoration: underline">More</a>
                                        </td>
                                        <td>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="{{ url('members/view/'.$user->id) }}" class="btn btn-primary" title="Block">
                                                        <span class="fas fa-eye mr-2"></span>View</a>
                                                </li>
                                            </ul>
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
            <div class="modal fade bd-example-modal-xl" id="detail_modal" tabindex="-1" role="dialog"
                 aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div style="max-width:600px;"  class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myLargeModalLabel">Request Detail</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="market_create_modalbody">
                            <div class="container">
                                <div class="form-group">
                                    <label class="">Text</label>
                                    <textarea type="text" class="form-control" id="message" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <!-- page script -->
    <script>
        $(function () {
            $("#copywriterTable").DataTable({
                "language": {"zeroRecords": 'No copywriters'}
            });
        });

        function showDetail(str) {
            $('#message').val(str);
            $('#detail_modal').modal('show');
        }
    </script>
@endsection