@extends('layouts.main')
    <style>
        .show {
            display: block;
        }
        .hide {
            display: none;
        }

    </style>
@section('content')
    <section class="admin-content">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-12 m-auto text-white p-b-30">
                        <h2> <span class="btn btn-white-translucent"><i class="mdi mdi-format-color-text "></i></span> Browse project</h2>
                        <p class="opacity-75">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At autem corporis dicta dignissimos earum ex facere fuga, impedit itaque minima nisi numquam officiis quisquam sequi sint sit sunt tempora voluptate
                        </p>
                    </div>
                    <div class="col-md-12 m-auto p-b-30">
                        <div class="card m-b-30">
                            <div class="card-header">
                                <h5 class="m-b-0">
                                    Filters:
                                </h5>

                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group  col-md-3">
                                        <label>
                                            Select Category
                                        </label>
                                        <select class="custom-select" id="categorySelector">
                                            <option value="0" selected>All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <label>
                                            Select Language 
                                            @if(!isset(auth()->user()->languages))
                                                <small class="text-red">select your languages first</small>
                                            @endif
                                        </label>
                                        <select class="custom-select" id="languageSelector">
                                            <option value="0" selected>All Languages</option>
                                            @foreach($languages as $key=>$language)
                                                <option value="{{$key}}">{{$language}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group  col-md-3">
                                        <label for="rateRanger">Prince per 100 words: <b>3,21 PLN</b></label>
                                        <input type="number" placeholder="input the amount" name="rateRanger" class="form-control" min="0" step="0.1" value="" id="rateRanger">
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <div class="card-header">
                                            <h5 class="m-b-0">
                                                <button class="btn btn-default" onclick="showAdditionalFilter()">Additional filters:</button>
                                            </h5>
                                        </div>
                                        <div class="col-md">			
                                            <div class="card-body show" id="additional_filter_block">
                                                <div class="tag-input">
                                                    <input checked id="oreo" type="checkbox">
                                                    <label for="oreo">Premium Order</label>
                                                </div>
                                                <div class="tag-input">
                                                    <input id="kitkat" type="checkbox">
                                                    <label for="kitkat">NDA</label>
                                                </div>
                                                <div class="tag-input">
                                                    <input id="Eclair" type="checkbox">
                                                    <label for="Eclair">Urgent Order</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid pull-up">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-t-10" id="table_content">
                                <table id="example" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Price Full</th>
                                        <th title="Price per 1000 zzs">Rate</th>
                                        <th>Status</th>
                                        <th>Start date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $key=>$project)
                                    <tr>
                                        <td>#{{ $project->id }}</td>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->category->title }}</td>
                                        <td>{{ $project->budget }} PLN</td>
                                        <td>{{ $project->rate }} PLN <small> /100 words</small></td>
                                        <td class="text-capitalize {{$project->status}}">{{ $project->status }}</td>
                                        <td>{{ $project->created_at }}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{ route('projects.view', ['project' => $project]) }}">View</a></td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Price Full</th>
                                        <th title="Price per 1000 zzs">Rate</th>
                                        <th>Status</th>
                                        <th>Start date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
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
        $(function () {
            $('#history').DataTable({
                ordering: true
            });
        });
    </script>
    <script>
        var token = '{{ csrf_token() }}';
        $(function () {
//           $('#example').DataTable({
//               lengthMenu: [5, 10, 25, 50],
//               pageLength: 10,
//               language: {"emptyTable": "No Projects"},
//               ordering: false
//           });

           $('#rateRanger').change(function () {
               $('#outputRange').html($(this).val());
               updateTarget();
           });

           $('#categorySelector').change(function () {
               updateTarget();
           });
           $('#languageSelector').change(function () {
               updateTarget();
           });
        });

        function updateTarget() {
            var categoryId = $('#categorySelector').val();
            var language = $('#languageSelector').val();
            var rate = $('#rateRanger').val();
            $.ajax({
                url: '{{ route('projects.ajax.browse') }}',
                method: 'post',
                data: { rate: rate, categoryId: categoryId, language:language,_token: token},
                success: function (res) {
                    $('#table_content').html(res);
                },
                error: function (err) {
                    alert(err);
                }
            })
        }

        function showAdditionalFilter() {
            if($('#additional_filter_block').hasClass('show')){
                $('#additional_filter_block').removeClass('show').addClass('hide');
                return;
            }
            if($('#additional_filter_block').hasClass('hide')){
                $('#additional_filter_block').removeClass('hide').addClass('show');
                return;
            }
        }
    </script>
@endsection