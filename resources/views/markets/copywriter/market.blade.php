@extends('layouts.main')
@section('style')
{{--    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/summernote-bs4.min.css')}}">--}}
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
        var nCharacters = 0;
        var min_chars = 2500;
        (function ($) {
            'use strict';

            tinymce.init({
                selector: '#tinymce',
                menubar: false,
                height: 600,
                // plugins: [
                //     'advlist autolink lists link image charmap print preview anchor textcolor',
                //     'searchreplace visualblocks code fullscreen',
                //     'insertdatetime media table contextmenu paste code help wordcount'
                // ],
                // toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                toolbar: 'undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tinymce.com/css/codepen.min.css'],
                init_instance_callback: function(editor) {
                    editor.on('change', function(e) {
                        nCharacters = tinymce.activeEditor.getContent({format: 'text'}).length;
                        updateStatus()
                    });
                    editor.on('keydown', function (e) {
                        if(editor.getContent({format: 'text'}) === '\n') {
                            nCharacters = 0;
                        }else{
                            nCharacters = editor.getContent({format: 'text'}).length;
                        }
                        updateStatus();
                    });
                }
            });

        })(window.jQuery);

        function updateStatus() {
            document.getElementById('status').innerHTML = (nCharacters + ' / ' + min_chars) + ' required';
            document.getElementById('status').style.color="green";
            document.getElementById('submit').disabled = false;
            if(nCharacters < min_chars ) {
                document.getElementById('submit').disabled = true;
                document.getElementById('status').style.color="red";
            }
        }
    </script>
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

                    <div class="col-md-8 m-auto text-white p-b-30">
                        <h2> <span class="btn btn-white-translucent"><i class="mdi mdi-format-color-text "></i></span>
						Marketplace</h2>
                        <p class="opacity-75">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. At autem corporis dicta dignissimos earum ex facere fuga, impedit itaque minima nisi numquam officiis quisquam sequi sint sit sunt tempora voluptate
                        </p>

                      
                    </div>
                    <div class="col-md-4 m-auto text-white p-b-30">
                        <div class="text-md-right">
                            <a href="#!" type="button" class="btn btn-success" data-toggle="modal"
                               data-target=".bd-example-modal-xl"> <i class="mdi mdi-plus"></i> Create New Sell</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="container pull-up">
            <div class="row">
                <div class="col-lg-12 m-b-30">
                    <!--card begins-->
                    <div class="card m-b-30">

                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="tabHeader nav-link active" id="home-tab" href="javascript: setTab('home')"
                                       aria-controls="home" aria-selected="true">Active Sells</a>
                                </li>
                                <li class="nav-item">
                                    <a class="tabHeader nav-link" id="profile-tab" href="javascript: setTab('profile')"
                                       aria-controls="profile" aria-selected="false">History Sells</a>
                                </li>

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pillhome" role="tabpanel"
                                     aria-labelledby="home-tab">

                                    <div class="table-responsive p-t-10">
                                        <table class="example table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Characters</th>
                                                <th title="Price per 1000 zzs">Rate</th>
                                                <th>Price</th>
                                                <th>Keyword</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($activeSells as $key=>$sell)
                                            <tr>
                                                <td>{{ $sell->id }}</td>
                                                <td> {{ $sell->category->title }}</td>
                                                <td class="text-capitalize"> {{ $sell->status }}</td>
                                                <td> {{ $sell->nChars }}</td>
                                                <td> {{ $sell->rate }}</td>
                                                <td> {{ $sell->budget }}</td>
                                                <td> {{ $sell->keyword }}</td>
                                                <td>
                                                    <a class="btn btn-primary"
                                                       href="javascript: viewSell('{{ $sell->id }}')">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach

                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pillprofile" role="tabpanel"
                                     aria-labelledby="profile-tab">
                                    <div class="table-responsive p-t-10">
                                        <table class="example table" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Characters</th>
                                                <th title="Price per 1000 zzs">Rate</th>
                                                <th>Price</th>
                                                <th>Keyword</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($historySells as $key=>$sell)
                                                <tr>
                                                    <td>{{ $sell->id }}</td>
                                                    <td> {{ $sell->category->title ?? '' }}</td>
                                                    <td class="text-capitalize"> {{ $sell->status }}</td>
                                                    <td> {{ $sell->nChars }}</td>
                                                    <td> {{ $sell->rate }}</td>
                                                    <td> {{ $sell->budget }}</td>
                                                    <td> {{ $sell->keyword }}</td>
                                                    <td>
                                                        <a class="btn btn-primary"
                                                           href="javascript: viewSell('{{ $sell->id }}')">
                                                            View
                                                        </a>
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
    @include('modals.market_freelancer_modal')
@endsection
@section('script')
    <!--Additional Page includes-->
    <script src="{{asset('assets/vendor/DataTables/datatables.min.js')}}"></script>
{{--    <script src="{{asset('assets/js/datatable-data.js')}}"></script>--}}
    <!--chart data for current dashboard-->
    <script>
        $('.example').DataTable({
            lengthMenu: [5, 10, 25, 50],
            pageLength: 10,
            language: {"emptyTable": "No Markets"}
        });

        var _token = '{{ csrf_token() }}';
        var fee = parseFloat('{{ config('settings.payment.fee') }}');
        var ratelimit = parseFloat('{{ config('settings.payment.ratelimit') }}');
        var minCharacters = 2500;
        var price = 0;
        var nCharacters = 1;
        var rate = 0;
        var sellId = 0;

        $(function () {
           init();
        });

        function init() {
            price = $('#price').val() || 0;
            nCharacters = tinymce.activeEditor.getContent({format: 'text'}).length || 0;
            $('#nCharacters').html(nCharacters);
            rate = (price/nCharacters * 1000).toFixed();
            $('#profit').html((price * (100 - fee)/100).toFixed(2));
            $('#rate').html(rate);
        }

        $('#price').change(function () {
            price = $(this).val();
            $('#profit').html((price * (100 - fee)/100).toFixed(2));
            nCharacters = tinymce.activeEditor.getContent({format: 'text'}).length;
            $('#nCharacters').html(nCharacters);
            if(nCharacters>0) {
                rate = (price/nCharacters * 1000).toFixed();
                $('#rate').html(rate);
            }
        });

        $('#submit').click(function () {
            var content = tinymce.activeEditor.getContent({format: 'html'});
            var categoryId = $('#categoryId').val();
            var keyword = $('#keyword').val();
            if(nCharacters < minCharacters) {
                $('#alertBlock').html('Minimal text is ' + minCharacters+' characters');
                $('#alertBlock').show();
                return;
            }
            if(rate >ratelimit) {
                $('#alertBlock').html('Maximum price per 1000 zzs is ' + ratelimit);
                $('#alertBlock').show();
                return;
            }

            var title = $('#title').val();

            $.ajax({
                url: '{{ route('sells.post') }}',
                method: 'post',
                data: {
                    _token: _token,
                    title: title,
                    text: content,
                    price: price,
                    categoryId: categoryId,
                    rate: rate,
                    nChar: nCharacters,
                    keyword: keyword,
                    id: sellId
                },
                success: function (res) {
                    if(res.status){
                        location.reload();
                    }else{
                        if(res.errors){
                            var msg = '';
                            Object.keys(res.errors).map(function(key){
                                msg += (key+": "+res.errors[key][0] + "\n");
                            });
                            $.notify({
                                // options
                                title: 'Warning',
                                message: msg
                            }, {
                                placement: {
                                    align: "right",
                                    from: "bottom"
                                },
                                timer: 500,
                                // settings
                                type: 'danger',
                            });
                        }
                        $('.bd-example-modal-xl').modal('toggle');
                    }
                },
                error: function (err) {

                }
            })
        });

        function setTab(name) {
            console.log(name);
            $('.tabHeader').removeClass('active');
            $('.tab-pane').removeClass('show').removeClass('active');
            $('#' + name+'-tab').addClass('active');
            $('#pill' + name).addClass('show').addClass('active');
        }

        function viewSell(sell) {
            sellId = sell;
            $.get('{{ url('/sells/view/') }}' + '/' + sell, function (res) {
                tinymce.activeEditor.setContent(res.sell.text);
                $('#price').val(res.sell.budget);
                $('#keyword').val(res.sell.keyword);
                $('#categoryId').val(res.sell.categoryId);
                init();
                $('.bd-example-modal-xl').modal('show');
            })
        }
    </script>
@endsection