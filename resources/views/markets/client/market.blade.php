@extends('layouts.main')
@section('style')
    <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/tinymce-data.js')}}"></script>
    <style>
        .row {
            margin: 0!important;
        }
    </style>
@endsection
@section('content')
    <section class="admin-content">
        <div class="bg-dark m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">

                    <div class="col-md-12 m-auto text-white p-b-30">
                        <h1> Marketplace</h1>
                        <p class="opacity-75">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At autem corporis dicta
                            dignissimos earum ex facere fuga, impedit itaque minima nisi numquam officiis quisquam sequi
                            sint sit sunt tempora voluptate
                        </p>
                        <div class="row">

                        </div>
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
                                <div class="form-group col-md-3">
                                   <label>Select Category</label>
                                    <select class="custom-select form-control" id="categoryId">
                                        <option value="0" selected>All orders</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
								<div class="form-group col-md-2">
                                   <label>Language</label>
                                    <select class="custom-select form-control" id="categoryId">
                                        <option value="0" selected>English</option>
                                       
                                            <option value="Russian">Russian</option>
                                      
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Price per Word (USD)</label>
                                    <input type="number" class="form-control" min="0" step="1"
                                           id="rateranger" value="0.1">
                                </div>
								<div class="form-group  col-md-2">
                                        <label>Minimal Words</label>
                                        <input type="number" min="100" step="1" class="form-control"
                                               placeholder="100 word's" id="min_chars">
                                    </div>
                                    
					<div class="form-group col-md-2">
                                        <label>Search Keyword</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

							</div>
							 <button class="btn m-b-15 ml-2 mr-2 btn-light" type="button"
                                onclick="applyFilter()">Apply Filters</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid pull-up">
            <div class="row">

                <div class="col-lg-12 m-b-30">

                    <!--card begins-->
                    <div class="card m-b-30">

                        <div class="card-body">

                            <div class="table-responsive p-t-10" >
                                <table id="example" class="table" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Article</th>
                                        <th>Category</th>
                                        <th>Rating</th>
                                        <th>Characters</th>
                                        <th title="Price per 1000 zzs">Words</th>
                                        <th>Rate</th>
                                        <th>Keyword</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableblock">
                                    @foreach($activeSells as $key=>$sell)
                                    <tr>
					   <td>
                                  <h5>{{ \Illuminate\Support\Str::limit($sell->title, 70) }}</h5><br>
					<p>"{{ \Illuminate\Support\Str::limit(strip_tags($sell->text), 130) }}"</p>
                                    </td>
					   <td><span class="badge badge-soft-primary"> {{ $sell->category->title }}</span></td>
                                    <td> <p>3.5/5.0</p><br><div></div> </td>
                                     <td> <span>{{ $sell->nChars }}<small>zzs</small></span> </td>
                                    <td>{{ str_word_count(strip_tags($sell->text)) }}</td>
                                     <td>{{ $sell->rate }} PLN  </td>
                                     <td> <p>{{ $sell->keyword }}</p> </td>
<td>
<p>Price: {{ roundPrice($sell->budget) }} PLN</p>
<a class="btn btn-dark" href="{{ url('/sells/buy/'.$sell->id)}}"> Buy Now</a>
                                    </td>

                                    <!--- Old code
									<td>{{ $sell->id }}</td>
                                        <td>{{ $sell->category->title }}</td>
                                        <td>{{ $sell->status }}</td>
                                        <td>{{ $sell->nChars }}</td>
                                        <td>{{ $sell->rate }}</td>
                                        <td>{{ $sell->budget }}</td>
                                        <td>{{ $sell->keyword }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ url('/sells/buy/'.$sell->id)}}">
                                                Buy It
                                            </a>
                                        </td> ---->
                                    </tr>
                                    @endforeach

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <!--card ends-->
                </div>
            </div>
        </div>
    </section>
    @include('modals.market_user_modal')
@endsection

@section('script')
    <!--Additional Page includes-->
    <script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable-data.js')}}"></script>
{{--    <script src="{{asset('assets/js/bootstrap-notify-data.js')}}"></script>--}}
    <!--chart data for current dashboard-->

    <script>
        var _token = '{{ csrf_token() }}';

        $('#rateranger').change(function () {
            $('#rate').html($(this).val());
        });

        function applyFilter() {
            var categoryId = $('#categoryId').val();
            var rate = $('#rateranger').val();
            var min_chars = $('#min_chars').val();
            var max_chars = $('#max_chars').val();

            $.ajax({
                url: '{{ route('sell.search') }}',
                method: 'POST',
                data: {
                    _token: _token,
                    categoryId: categoryId,
                    rate: rate,
                    min_chars: min_chars,
                    max_chars: max_chars
                },
                success: function (res) {
                    $('#tableblock').html(res);
                },
                error: function (err) {

                }
            })
        }

        $(function () {
            @if($errors->has('status'))
            $.notify({
                // options
                title: 'Alert, ',
                message: '{{ $errors->first('status') }}'
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },

                timer: 500,
                // settings
                type: 'danger',

            });
            @endif

            @if(session()->has('status'))
            $.notify({
                // options
                title: 'Successfully',
                message: ''
            }, {
                placement: {
                    align: "center",
                    from: "top"
                },

                timer: 500,
                // settings
                type: 'success',

            });
            @endif
        });
    </script>
@endsection

