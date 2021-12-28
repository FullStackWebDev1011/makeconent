@extends('layouts.admin')

@section('title', 'Marketplaces')
@section('subtitle', 'Marketplaces')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Projects</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                    <i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fas fa-times"></i></button>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table id="projectTable" class="table table-hover text-nowrap projects">
                                <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th style="width: 25%">
                                        Seller
                                    </th>
                                    <th style="width: 25%">
                                        Buyer
                                    </th>
{{--                                    <th style="width: 20%">--}}
{{--                                        Text--}}
{{--                                    </th>--}}
                                    <th style="width: 10%">
                                        Category
                                    </th>
                                    <th style="width: 10%">
                                        Price Full (PLN)
                                    </th>
                                    <th style="width: 5%" title="Price per 1000 zzs">
                                        Rate (PLN)
                                    </th>
                                    <th style="width: 5%">
                                        Start Date
                                    </th>

                                    <th style="width: 3%" class="text-center">
                                        Status
                                    </th>
                                    <th style="width: 16%">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($markets as $key=>$project)
                                    <tr>
                                        <td>{{ $project->id }}</td>
                                        <td>
                                            <ul class="list-inline v-center">
                                                <li class="list-inline-item">
                                                    <img alt="Avatar" class="table-avatar"
                                                         src="{{asset($project->seller->avatar?$project->seller->avatar:'assets/img/users/avatar.png')}}">
                                                </li>
                                                <li class="list-inline-item">
                                                    {{ $project->seller->name }}<br/>
                                                    <small>{{ $project->seller->email }}</small>
                                                </li>
                                            </ul>
                                        </td>

                                        <td>
                                            <ul class="list-inline v-center">
                                                <li class="list-inline-item">
                                                    @if($project->buyer)
                                                        <img alt="Avatar" class="table-avatar"
                                                             src="{{asset($project->buyer?$project->buyer->avatar?$project->buyer->avatar:'assets/img/users/avatar.png':'assets/img/users/avatar.png')}}">
                                                    @endif
                                                </li>
                                                <li class="list-inline-item">
                                                    {{ $project->buyer ? $project->buyer->name : '' }}<br/>
                                                    <small>{{ $project->buyer ? $project->buyer->email : '' }}</small>
                                                </li>
                                            </ul>
                                        </td>

{{--                                        <td>{{ $project->text, 0, 20}}</td>--}}
                                        <td>{{ $project->category->title }}</td>
                                        <td>{{ $project->budget }}</td>
                                        {{--                                        <td>{{ $project->quality ? $project->category[$project->quality . '_min'] : $project->rate }}</td>--}}
                                        <td>{{ $project->rate }}</td>
                                        <td>{{ $project->created_at }}</td>
                                        {{--                    <td>{{ substr($project->description, 0, 20) }}</td>--}}
                                        <td class="tag-status">{{ $project->status }}</td>
                                        <td>
                                            <ul class="list-inline">

                                                <li class="list-inline-item">
                                                    <a class="btn btn-primary btn-sm"
{{--                                                       href="{{ url('sells/view/' . $project->id)}}"--}}
                                                       href="#"
                                                    >
                                                        View</a>
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
    <!-- /.content -->
@endsection

@section('script')
    <!-- page script -->
    <script>
        $(function () {
            $("#projectTable").DataTable();
        });
    </script>
@endsection