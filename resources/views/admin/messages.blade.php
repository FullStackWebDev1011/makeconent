@extends('layouts.admin')

@section('title', '')
@section('style')
@endsection

@section('subtitle', 'Marketplaces')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-md-12 p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover text-nowrap projects datatable">
                                            <thead class="">
                                            <tr>
                                                <th scope="col">ID #</th>
                                                <th scope="col">Sender</th>
                                                <th scope="col">Receiver</th>
                                                <th scope="col">Date</th>
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
                                                    <td class="align-middle">
                                                        <ul class="list-inline v-center">
                                                            <li class="list-inline-item">
                                                                @if($message->send_user->avatar) <img class="table-avatar" src="{{ asset($message->send_user->avatar) }}">
                                                                @else <img class="table-avatar" src="{{ asset('assets/img/users/avatar.png') }}"> @endif
                                                            </li>
                                                            <li class="list-inline-item">
                                                                {{ $message->send_user->fullname ?? $message->send_user->name }}<br>
                                                                <small>{{ $message->send_user->email }}</small>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class="align-middle">
                                                        <ul class="list-inline v-center">
                                                            <li class="list-inline-item">
                                                                @if($message->receive_user->avatar) <img class="table-avatar" src="{{ asset($message->receive_user->avatar) }}">
                                                                @else <img class="table-avatar" src="{{ asset('assets/img/users/avatar.png') }}"> @endif
                                                            </li>
                                                            <li class="list-inline-item">
                                                                {{ $message->receive_user->fullname ?? $message->receive_user->name }}<br>
                                                                <small>{{ $message->receive_user->email }}</small>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td class="align-middle">{{ $message->created_at }}
                                                    </td>

                                                    <td class="align-middle">
                                                        {{ $message->text }}
                                                    </td>
                                                    <td class="align-middle">
                                                        <button class="btn btn-danger"><span class="fa fa-trash"></span></button>
                                                        <button class="btn btn-primary"><span class="fa fa-eye"></span></button>
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
    </section>
@endsection

@section('script')
@endsection