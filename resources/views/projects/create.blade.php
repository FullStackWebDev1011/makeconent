@extends('layouts.' . Auth::user()->role())
@section('style')
    <style>
        .qblock.active {
            background: lightgreen;
        }

        li.disabled {
            cursor: not-allowed;
        }

        li.disabled > a {
            pointer-events: none;
        }
    </style>
@endsection
@section('content')
    <section class="admin-content">
        <!-- BEGIN PlACE PAGE CONTENT HERE -->
        <!--  container or container-fluid as per your need           -->
        <div class="container">
            <section class="admin-content">

                <div class="container">
                    <div class="row m-h-100 align-items-center justify-content-center">
                        @if ($errors->any())
                            <div class="col-12 alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="col-lg-12 col-md-10 p-t-80">
                            <div class="card shadow-lg">
                                <div class="p-all-25">
                                    <div class="pull-up-sm text-center p-b-30">
                                        <div class="avatar avatar avatar-lg">
                                            <img src="{{ asset('assets/img/logo.svg') }}" alt="">
                                        </div>
                                    </div>
                                    <div id="rootwizard">
                                        <ul class="nav nav-pills nav-justified">
                                            <li class="nav-item"><a class="tabHeader nav-link active" id="tab1-header" href="javascript: setTab('tab1')">Informacje</a></li>
                                            <li class="nav-item disabled">
                                                <a class="tabHeader nav-link" id="tab2-header" href="javascript: setTab('tab2')">Płatność</a>
                                            </li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab">
                                                    <div class="text-center bg-dark rounded text-white p-all-15">
                                                        <p class="text-overline"> <i class="mdi mdi-information"></i> Cena za artykuł</p>
                                                        <h1 class="text-warning" id="budget">0.00 PLN</h1>
                                                    </div></a>
                                            </li>
                                        </ul>
                                        <form id="secondForm" class="form-horizontal" method="post" action="{{ route('projects.save')}}">
                                            @csrf
                                            <div class="tab-content">
                                                <div class="tab-pane p-t-20 p-b-20 show active" id="tab1">
                                                    {{--<form id="firstForm" class="form-horizontal" onsubmit="onFirstSubmit(event)">--}}
                                                    <input type="hidden" name="budget" />
                                                    <h3>
                                                        <span class="align-middle">Twoje zlecenie tekstow</span></h3>
                                                    <div class="form-group">
                                                        <label for="title">Tytuł zamówienia</label>
                                                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ?? '' }}"
                                                               aria-describedby="emailHelp" placeholder="Enter title" required>
                                                        <small id="emailHelp" class="form-text text-muted">We'll never
                                                            share your email with anyone else.
                                                        </small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="description">Opis Zamówienia</label>
                                                        <textarea type="text" class="form-control" name="description"
                                                                  id="description" style="min-height:220px;">{{ old('description') ?? '' }}</textarea>
                                                    </div>
                                                    <div class="form-group row" style="padding-left: 1.5rem;">

                                                        <label for="exampleInputPassword1" class="col-md-2">Minimal Characters</label>
                                                        <div class="col-md-9 input-group input-group-flush mb-3">
                                                            <input type="number" class="form-control form-control-prepended" min="2500" value="{{ old('min_chars') ?? '' }}"
                                                                   placeholder="Enter your vision" name="min_chars" id="min_chars" required>
                                                            <span class="input-group-addon">Charactes with Spaces</span>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <span class=" mdi mdi-eye "></span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group row" style="padding-left: 1.5rem;">

                                                        <label class="font-secondary col-md-2" >Select Category</label>
                                                        <select class="col-md-9 form-control js-select2" id="category" name="categoryId" style="width: 200px" required>
                                                            @foreach($categories as $key=>$category)
                                                                <option value="{{$category->id}}">{{ $category->title }}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                    <div class="form-group row" style="padding-left: 1.5rem;">
                                                        <label for="exampleInputPassword1" class="col-md-2">Your Budget</label>
                                                        <div class="col-md-9 input-group input-group-flush mb-3">
                                                            <input type="number" class="form-control form-control-prepended" value="{{ old('rate') ?? '' }}"
                                                                   step="0.1" min="1.00" placeholder="Enter your vision" name="rate" id="rate" required>
                                                            <span class="input-group-addon">PLN Brutto / Text</span>
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text">
                                                                    <span class=" mdi mdi-eye "></span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="price-block">
                                                            <p>Stawka za 1000 znaków: 6,00 zł (4,88 PLN netto)</p>
                                                            <p>Wartość całego zamówienia: 6,00 zł (4,88 zł netto)</p>
                                                        </div>
                                                        <div class=" m-b-10">
                                                            <label class="cstm-switch">
                                                                <span class="cstm-switch-description">Copywriter need write title for Text?</span>
                                                                <input type="checkbox" checked name="cp_write_title" value="1" class="cstm-switch-input">
                                                                <span class="cstm-switch-indicator bg-success "></span>
                                                            </label>

                                                        </div>
                                                        <div class=" m-b-10">
                                                            <label class="cstm-switch">
                                                                <span class="cstm-switch-description">Copywriter need bold keywords in Text?</span>
                                                                <input type="checkbox" checked name="cp_bold_keyword" value="1" class="cstm-switch-input">
                                                                <span class="cstm-switch-indicator bg-success "></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="col-lg-12 m-b-30">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <p class=" text-overline">
                                                                        Sugerowane Stawki dla wybranej kategorii za 1000 zzs*
                                                                    </p>
                                                                    <div class="row">
                                                                        <div class="col-md-4 p-t-15 qblock" id="q1_block">
                                                                            <a href="javascript: setQuality('q1')">
                                                                                <h5>Niska Jakość</h5>
                                                                                <h4 class="text-success">
                                                                                        <span id="q1">
                                                                                            @if(count($categories) > 0)
                                                                                                {{ $categories[0]->q1_min . ' - ' . $categories[0]->q1_max }}
                                                                                            @else
                                                                                                0 - 0
                                                                                            @endif
                                                                                        </span> PLN
                                                                                </h4>
                                                                                <p class=" text-overline">
                                                                                    (Stawka Minimalna)
                                                                                </p>
                                                                            </a>
                                                                        </div>

                                                                        <div class="col-md-4 p-t-15 qblock" id="q2_block">
                                                                            <a href="javascript: setQuality('q2')">
                                                                                <h5>Średnia Jakość</h5>
                                                                                <h4 class="text-success">
                                                                                        <span id="q2">
                                                                                            @if(count($categories) > 0)
                                                                                                {{ $categories[0]->q2_min . ' - ' . $categories[0]->q2_max }}
                                                                                            @else
                                                                                                0 - 0
                                                                                            @endif
                                                                                            </span> PLN
                                                                                </h4>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-md-4 p-t-15 qblock" id="q3_block">
                                                                            <a href="javascript: setQuality('q3')">
                                                                                <h5>Wysoka Jakość</h5>
                                                                                <h4 class="text-success">
                                                                                        <span id="q3">
                                                                                            @if(count($categories) > 0)
                                                                                                {{ $categories[0]->q3_min . ' - ' . $categories[0]->q3_max }}
                                                                                            @else
                                                                                                0 - 0
                                                                                            @endif
                                                                                        </span>+ PLN
                                                                                </h4>
                                                                            </a>
                                                                        </div>
                                                                        <input type="hidden" name="quality" value="">
                                                                    </div>
                                                                    <p class=" text-overline">
                                                                        *Wszystkie stawki podane są brutto, im wyższa stawka tym szybciej twój tekst zostanie zrealizowany.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <ul class="nav nav-pills justify-content-between wizard m-b-30">
                                                        <li class="nav-item">
                                                            <button type="button" onclick="onFirstSubmit()" id="nextBtn" class="nav-link btn-success">Proceed</button>
                                                        </li>
                                                    </ul>

                                                </div>
                                                <div class="tab-pane p-t-20 p-b-20" id="tab2">

                                                    <div class="option-box">
                                                        <input id="payment_method1" class="payment_method" value="PayU" checked name="payment_method" type="radio" required>
                                                        <label for="payment_method1">
                                                                <span class="radio-content">
                                                                    <span class="h6 d-block">Pay with PayU <span class="badge-soft-primary badge">+2,6% FEE</span>
                                                                    </span>
                                                                    <span class="text-muted m-b-41">
                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                        elit. Accusantium blanditiis ducimus ipsa provident
                                                                        quae quaerat similique? Consequatur consequuntur
                                                                        cum, inventore nihil porro quis. Ad assumenda
                                                                        eligendi illum impedit quis totam.
                                                                    </span>
                                                                </span>
                                                        </label>
                                                    </div>
                                                    <div class="option-box">
                                                        <input id="payment_method2" class="payment_method" value="wallet" name="payment_method" type="radio" required>
                                                        <label for="payment_method2">
                                                                <span class="radio-content">
                                                                    <span class="h6 d-block">Pay with your wallet funds
                                                                    </span>
                                                                    <span class="text-muted m-b-41">
                                                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                                                        elit. Accusantium blanditiis ducimus ipsa provident
                                                                        quae quaerat similique? Consequatur consequuntur
                                                                        cum, inventore nihil porro quis. Ad assumenda
                                                                        eligendi illum impedit quis totam.
                                                                    </span>
                                                                </span>
                                                        </label>
                                                    </div>

                                                    <button onclick="showPreloader();" name="status" value="sketch" class="btn btn-primary" type="submit">Save as Sketch</button>
                                                    {{--<a href="javascript: setStatus('sketch')" id="trigger-content-04" class="btn btn-primary">Save as Sketch</a>--}}
                                                    {{--<a href="javascript: setStatus('open')" id="trigger-content-04" class="btn btn-primary">Process Payment</a>--}}
                                                    {{--<input type="hidden" name="status" id="status" value="sketch">--}}
                                                    <ul class="nav nav-pills justify-content-between wizard m-b-30 m-t-10">
                                                        <li class="nav-item">
                                                            <button type="submit" name="status" value="open" onclick="showPreloader();" id="submitBtn" class="nav-link btn-success">Proceed</button>
                                                        </li>
                                                    </ul>

                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- END PLACE PAGE CONTENT HERE -->
    </section>
@endsection

@section('script')
    <!--page specific scripts for demo-->

    <script src="{{asset('assets/vendor/jquery.bootstrap.wizard/jquery.bootstrap.wizard.min.js')}}"></script>
    <script src="{{asset('assets/js/form-wizard-data.js')}}"></script>
    <script src="{{asset('assets/vendor/blockui/jquery.blockUI.js')}}"></script>
    <script src="{{asset('assets/js/blockui-data.js')}}"></script>

    <script>
        var _token = '{{ csrf_token() }}';
        var curCat;
        var quality;
        $(function () {
            getCurCat();
            $('#category').change(function () {
                getCurCat();
            });
            $('#rate').change(function () {
                calcBudget();
            });
            $('#min_chars').change(function () {
                if (parseInt($(this).val()) < parseInt($(this).attr('min'))) {
                    $(this).val($(this).attr('min'));
                }
                calcBudget();
            });
        });

        function showPreloader() {
            $("body").block({
                timeout:   5000,
            });
        }

        function onFirstSubmit(){
            setTab('tab2');
        }

        function onSecondSubmit(event) {
            event.preventDefault();
            console.log('second submit');
            var form1Val = $('#firstForm').serializeArray();
            var form2Val = $('#secondForm').serializeArray();
            var formVal = form1Val.concat(form2Val);
            console.log(formVal);
            var data = {
                _token: _token
            };
            for(var i = 0; i<formVal.length; i++) {
                data[formVal[i].name] = formVal[i].value;
            }

            $.ajax({
                url: '{{ route('projects.save') }}',
                method: 'POST',
                data: data,
                success: function (res) {
                    $.notify({
                        // options
                        title: 'Success',
                        message: res.message
                    }, {
                        placement: {
                            align: "center",
                            from: "top"
                        },
                        timer: 500,
                        // settings
                        type: 'success',
                    });
                },
                error: function (err) {
                    var errors = err.responseJSON.errors;
                    var errorStr = "";
                    Object.keys(errors).map(function (key) {
                        errorStr += (errors[key]+'\n');
                    });
                    $.notify({
                        // options
                        title: 'Warning',
                        message: errorStr
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
            })
        }

        function getCurCat() {

            var catId = $('#category').val();
            $('#catId').val(catId);
            $.get('{{url('/category/user/get')}}' + '?id=' + catId, function (res) {
                curCat = res;
                console.log('curCat ==== ', curCat);
                $('#q1').html(curCat.q1_min + ' - ' + curCat.q1_max);
                $('#q2').html(curCat.q2_min + ' - ' + curCat.q2_max);
                $('#q3').html(curCat.q3_min + ' - ' + curCat.q3_max);
            })
        }

        function setStatus(status) {
            $('#status').val(status);
        }

        function setQuality(q) {
            var isActive = $('#' + q + '_block').hasClass('active');
            quality = '';
            $('.qblock').removeClass('active');
            if(!isActive) {
                $('#' + q + '_block').addClass('active');
                quality = q;
            }
            $('input[name="quality"]').val(quality);

            // calculate budget
            calcBudget();
        }

        function calcBudget() {
            // calculate budget
            var min_chars = parseInt($('#min_chars').val());
            var rate = $('#rate').val();
            if(quality) {
                rate = curCat[quality + '_min'];
            }
            console.log(min_chars, rate);
            if(rate == NaN) {
                rate = 0;
            }
            var budget = rate * min_chars / 1000;
            $('#budget').html(budget.toFixed(2) + ' PLN');
            $('input[name="budget"]').val(budget);
        }

        function setTab(name) {
            console.log(name);
            $('.tabHeader').removeClass('active');
            $('.tab-pane').removeClass('show').removeClass('active');
            $('#' + name + '-header').addClass('active');
            $('#' + name).addClass('show').addClass('active');
        }

    </script>
@endsection

