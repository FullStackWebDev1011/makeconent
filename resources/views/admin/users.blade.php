@extends('layouts.admin')

@section('title', 'Users')
@section('style')

@endsection

@section('subtitle', 'Users')

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
                            <h3 class="card-title"><span class="fas fa-users mr-2"></span>Users - {{ count($users) }} total</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-1">
                            <table id="usersTable" class="table table-hover text-nowrap projects">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Status</th>
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
        </div>
    </section>
@endsection
@section('script')
    <!-- page script -->
    <script>
        $(function () {
            $("#usersTable").DataTable();
        });
    </script>
@endsection