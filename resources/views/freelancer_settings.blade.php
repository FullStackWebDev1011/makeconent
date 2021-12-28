@extends('layouts.main')
@section('style')
    <style>
        .avatar-input .avatar-file-picker {
            position: relative !important;
        }
    </style>
	<link rel="stylesheet" href="{{ asset('plugins/input-int-telephone/css/intlTelInput.min.css') }}">
@endsection
@section('content')
    <section class="admin-content ">
        <div class="bg-dark bg-dots m-b-30">
            <div class="container">
                <div class="row p-b-60 p-t-60">
                    <div class="col-lg-8 text-center mx-auto text-white p-b-30">
                        <div class="m-b-10">
                            <div class="avatar avatar-lg ">
                                <div class="avatar-title bg-info rounded-circle mdi mdi-settings "></div>
                            </div>
                        </div>
                        <h3>User Settings </h3>
                    </div>
                </div>
            </div>
        </div>
        <section class="pull-up">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-lg-12 mb-2">
                        <div class="card">
                            <div class="card-body">
                                
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item"><a class="tabHeader nav-link active" id="tab1-header" href="javascript: setTab('tab1')">Profile & Jobs Setting</a></li>
                                    <li class="nav-item">
                                        <a class="tabHeader nav-link" id="tab2-header" href="javascript: setTab('tab2')">Payments </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tabHeader nav-link" id="tab3-header" href="javascript: setTab('tab3')">Password & Logs </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tabHeader nav-link" id="tab4-header" href="javascript: setTab('tab4')">Trust & Veryfication </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="tabHeader nav-link" id="tab5-header" href="javascript: setTab('tab5')">Email & Notyfication </a>
                                    </li>
                                </ul>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="tab-content">
                            <div class="tab-pane p-t-20 p-b-20 show active" id="tab1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card py-3 m-b-30">
                                            <div class="card-body">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <form action="{{ route('settings.copywriter.save') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <h3 class="">Personal Data</h3>
                                                    <p class="text-muted">
                                                        Use this page to update your contact information and change your password.
                                                    </p>
                                                    <div class="">
                                                        <div class="row mb-4">
                                                            <div class="col-md-2">
                                                                <label class="avatar-input">
                                                                    <span class="avatar avatar-xl">
                                                                        @if($user->avatar)
                                                                            <img src="{{ asset($user->avatar) }}" alt="..."
                                                                                class="avatar-img rounded-circle">
                                                                        @else
                                                                            <img src="/assets/img/users/avatar.png" alt="..."
                                                                                class="avatar-img rounded-circle">
                                                                        @endif
                                                                        <span class="avatar-input-icon rounded-circle">
                                                                            <i class="mdi mdi-upload mdi-24px"></i>
                                                                        </span>
                                                                    </span>
                                                                    <input type="file" name="avatar" class="avatar-file-picker">
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p class="js_categories_text_container"><span class="js_categories_text">{{ auth()->user()->getCategoriesTitle() ?: 'Click to enter the catorgys' }}</span> <i class="mdi mdi-pencil"></i></p>
                                                                <div class="form-group js_categories_edit" style="display: none">
                                                                    <label class="font-secondary">Choose 3 category</label><br>
                                                                    <select multiple class="form-control js_select_category">
                                                                        @foreach($categories as $category)
                                                                            <option {{ in_array($category->id, auth()->user()->categories->pluck('id')->toArray())? ' selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <p class="js_languages_text_container"><span class="js_languages_text">{{ auth()->user()->getLanguagesTitle() ?: 'Click to enter the languages ​​in which you write (max 3)' }}</span> <i class="mdi mdi-pencil"></i></p>
                                                                <div class="form-group js_languages_edit" style="display: none">
                                                                    <label class="font-secondary">Choose 3 languages (max 3)</label><br>
                                                                    <select multiple class="form-control js_select_language" name="languages[]">
                                                                        @foreach($languages as $key=>$language)
                                                                            <option {{ in_array($key, $user->languages?$user->languages:[])? ' selected' : '' }} value="{{ $key }}">{{ $language }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <p class="js_about_text_container"><span class="js_about_text_text">{{ $user->about ?? '' }}</span><i class="mdi mdi-pencil"></i></p>
                                                                <textarea class="form-control js_about_text_edit" style="display: none">{{ $user->about ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="cstm-switch">
                                                                <input id="company" onclick="changeRole()" type="checkbox" value="1"
                                                                    name="isCompany"
                                                                    @if(old('isCompany') ?? $user->isCompany) checked
                                                                    @endif class="cstm-switch-input">
                                                                <span class="cstm-switch-indicator "></span>
                                                                <span class="cstm-switch-description">{{__('main.company_account')}}
                                                                    ? </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        @php
                                                            $fname = $user->fullname ? explode(' ', $user->fullname)[0]:'';
                                                            $lname = $user->fullname ? explode(' ', $user->fullname)[1] ?? '':'';
                                                        @endphp
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail6">Name <span class="text-red">*</span></label>
                                                            <input type="text" value="{{ old('lname') ?? $user->first_name }}" name="fname"
                                                                class="form-control" id="inputEmail6" placeholder="Name"
                                                                required>
                                                            @error('fname')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="asd">Surename <span class="text-red">*</span></label>
                                                            <input type="text" class="form-control" id="asd" name="lname"
                                                                placeholder="Surename" value="{{ old('lname') ?? $user->last_name }}" required>
                                                            @error('lname')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4">Email <span class="text-red">*</span></label>
                                                            <input disabled type="email" class="form-control" id="inputEmail4"
                                                                placeholder="Email" value="{{ old('email') ?? $user->email }}"
                                                                name="email" required>
                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4">Phone Number <span class="text-red">*</span></label>
                                                            <!-- <input type="text" class="form-control" placeholder="Phone number"
                                                                value="{{ old('phone') ?? $user->phone }}" name="phone"
                                                                autocapitalize="phone" required> -->
                                                            <input type="hidden" name="phone_prefix" value="{{ old('phone_prefix') ?? $user->phone_prefix }}">
                                                            <input type="tel" onkeydown="return mobileKey(event)" id="phone" value="{{ old('phone') ?? $user->phone }}" name="phone" class="form-control" required>
                                                            @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="country_id">Country <span class="text-red">*</span></label>
                                                            <select disabled class="col-md-9 form-control" value="{{ old('country_id') ?? $user->country_id }}" id="country_id" name="country_id" style="width: 200px" required>
                                                                @foreach($countries as $key=>$country)
                                                                    <option value="{{$country->id}}" {{ $country->id == $user->country_id  ? 'selected' : ''}} >{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="form-group company">
                                                        <label for="inputAddress">Company Name <span class="text-red">*</span></label>
                                                        <input type="text" pattern="[0-9]+" class="form-control" name="companyName"
                                                            placeholder="Company Name"
                                                            value="{{ old('companyName') ?? $user->companyName }}">
                                                        @error('companyName')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 form-group">
                                                            <label for="inputAddress2">Street <span class="text-red">*</span></label>
                                                            <input type="text" name="street" class="form-control" placeholder="Street"
                                                                value="{{ old('street') ?? $user->street }}">
                                                            @error('street')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-md-6 form-group">
                                                            <label for="inputAddress2">Apartment Number <span class="text-red">*</span></label>
                                                            <input type="text" name="apartment_number" class="form-control"
                                                                placeholder="Apartment Number"
                                                                value="{{ old('apartment_number') ?? $user->apartment_number }}">
                                                            @error('apartment_number')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 form-group">
                                                            <label for="inputAddress2">City <span class="text-red">*</span></label>
                                                            <input type="text" name="city" class="form-control" placeholder="City"
                                                                value="{{ old('city') ?? $user->city }}">
                                                            @error('city')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="inputAddress2">Post Code <span class="text-red">*</span></label>
                                                            <input type="number" name="post_code" class="form-control"
                                                                placeholder="Post Code"
                                                                value="{{ old('post_code') ?? $user->post_code }}">
                                                            @error('post_code')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    {{--@endif--}}
                                                    <div class="form-row">

                                                        {{--@if($user->isCompany == 0)--}}
                                                        <div class="form-group col-md-6 company">
                                                            <label for="inputPassword4">VAT Number <span
                                                                        class="text-red">*</span></label>
                                                            <input type="text" class="form-control" placeholder="VAT Number"
                                                                value="{{ old('vat_number') ?? $user->vat_number }}"
                                                                name="vat_number">
                                                            @error('vat_number')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-12">
                                                            <label for="inputPassword4">Bank Account <span
                                                                        class="text-red">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Bank Account"
                                                                name="bank_account" autocapitalize="bank_account"
                                                                value="{{ old('bank_account') ?? $user->bank_account }}" required>
                                                            @error('bank_account')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-6 form-group personal">
                                                            <label for="inputPassword4">Tax Office <span class="text-red">*</span></label>
                                                            <select class="form-control" id="tax_office" placeholder="Tax Office"
                                                                    name="tax_office_id">
                                                                @foreach($tax_offices as $tax_office)
                                                                    <option value="{{ $tax_office->id }}"
                                                                            @if((old('tax_office') ?? $user->tax_office_id) === $tax_office) selected @endif>{{ $tax_office->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('tax_office_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label for="inputAddress2">Pesel <span class="text-red">*</span></label>
                                                            <input type="text" name="pesel" class="form-control" placeholder="PESEL"
                                                                value="">
                                                        
                                                        </div>			
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-cta">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                            <div class="tab-pane p-t-20 p-b-20 show" id="tab2">
                                <h3 class="text-center">Payments Tab</h3>
                            </div>
                            <div class="tab-pane p-t-20 p-b-20 show" id="tab3">
                                <h3 class="text-center">Password & Logs Tab</h3>
								
								 <div class="col-lg-6">
                                        <div class="card  py-3 m-b-30">
                                            <div class="card-body">
                                                <form method="post" action="{{ route('user.update.password') }}">
                                                    @csrf
                                                    <h3>Password Change</h3>
                                                    <p class="text-muted">
                                                        Change your password here
                                                    </p>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="asd">New Password</label>
                                                            <input type="password" class="form-control" id="asd" name="password"
                                                                placeholder="Password " value="{{ old('password') }}" required>
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4">Re-Type New Password</label>
                                                            <input type="password" class="form-control" id="inputPassword4"
                                                                placeholder="Password" name="password_confirmation" value=""
                                                                autocapitalize="new-password">

                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success btn-cta">Save changes</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card  py-3 m-b-30">
                                            <div class="card-body">
                                                <h3>Account Security</h3>

                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="card m-b-30">

                                                            <div class="">
                                                                <div class="table-responsive">

                                                                    <table class="table table-hover ">
                                                                        <colgroup>
                                                                            <col style="width: 20%">
                                                                            <col style="width: 20%">
                                                                            <col style="width: 40%">
                                                                            <col style="width: 20%">
                                                                        </colgroup>
                                                                        <thead>
                                                                        <tr>
                                                                            <th>Action</th>
                                                                            <th>IP Adress</th>
                                                                            <th>Browser</th>
                                                                            <th>Time</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($logs as $key=>$log)
                                                                            <tr>
                                                                                <td>Log in</td>
                                                                                <td>{{ $log->ip }}</td>
                                                                                <td>
                                                                                    {{ $log->agent }}
                                                                                </td>
                                                                                <td> {{ $log->created_at }} </td>
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
                                        <div class="card  py-3 m-b-30">
                                            <div class="card-body">
                                                <h3>Your Account Status</h3>
                                                <p class="text-muted">
                                                    If you want change your type of account, write to support
                                                </p>
                                                <div class="row">
                                                    <div class="col-sm-4 m-b-30">
                                                        <div class="option-box-grid d-block">
                                                            <input id="check1"
                                                                @if($user->role() === 'freelancer') checked @endif
                                                                value="copywriter" name="userType" type="radio">
                                                            <label for="check1" class="d-block">
                                                            <span class="radio-content  p-all-15 text-center">
                                                                <span class="mdi h1 d-block mdi-google-adwords"></span>
                                                                <span class="h5">Copywriter</span>
                                                            </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 m-b-30">
                                                        <div class="option-box-grid d-block">
                                                            <input id="check3" @if($user->role() === 'client') checked @endif
                                                            name="userType" value="client" type="radio">
                                                            <label for="check3" class="d-block">
                                                            <span class="radio-content  p-all-15 text-center">
                                                                <span class="mdi h1 d-block mdi-google-adwords"></span>
                                                                <span class="h5">Employer</span>
                                                                <span class="d-block text-overline text-muted"></span>
                                                            </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4 m-b-30">
                                                        <div class="option-box-grid d-block">
                                                            <input id="check2" value="company" name="userType" type="radio">
                                                            <label for="check2" class="d-block">
                                                            <span class="radio-content  p-all-15 text-center">
                                                                <span class="mdi h1  d-block mdi-azure"></span>
                                                                <span class="h5">Enterprise</span>
                                                            </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="tab-pane p-t-20 p-b-20 show" id="tab4">
                                <h3 class="text-center">Trust & Veryfication</h3>
                            </div>
                            <div class="tab-pane p-t-20 p-b-20 show" id="tab5">
                                <h3 class="text-center">Email & Notyfication</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    <style>
        .js_categories_edit .select2-selection.select2-selection--multiple {
            min-width: 260px;
        }
        .js_languages_edit .select2-selection.select2-selection--multiple {
            min-width: 260px;
        }
    </style>
@endsection

@section('script')
    <!--Additional Page includes-->
    <script src="{{asset('plugins/input-int-telephone/js/intlTelInput.min.js')}}"></script>
    <script src="{{asset('plugins/input-int-telephone/js/intlTelInput-jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/setting-data.js')}}"></script>
    <!--chart data for current dashboard-->
    <script>
        $('.js_categories_text_container').click(function () {
            $('.js_categories_text_container').hide();
            $('.js_categories_edit').show();
        });
        $('.js_languages_text_container').click(function () {
            $('.js_languages_text_container').hide();
            $('.js_languages_edit').show();
        });
        $('.js_categories_edit').change(function () {
            var selected = [];
            $('.js_categories_edit :selected').each(function () {
                selected.push($(this).val());
            });
            $.ajax({
                url: '{{ route('settings.categories.save') }}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'categories': selected
                },
                success: function (res) {

                },
                error: function (err) {

                }
            });
//            $('.js_categories_edit').hide();
//            $('.js_categories_text_container').show();
        });
        $('.js_languages_edit').change(function () {
            var selected = [];
            $('.js_languages_edit :selected').each(function () {
                selected.push($(this).val());
            });
            $.ajax({
                url: '{{ route('settings.languages.save') }}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'languages': selected
                },
                success: function (res) {

                },
                error: function (err) {

                }
            });
//            $('.js_languages_edit').hide();
//            $('.js_languages_text_container').show();
        });

        $('.js_about_text_container').click(function () {
            $('.js_about_text_container').hide();
            $('.js_about_text_edit').show().select();
        });
        $('.js_about_text_edit').focusout(function () {
            $('.js_about_text_edit').hide();
            $('.js_about_text_container .js_about_text_text').text($('.js_about_text_edit').val()).show();
            $('.js_about_text_container').show();

            $.ajax({
                url: '{{ route('settings.about.save') }}',
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'about': $('.js_about_text_edit').val()
                },
                success: function (res) {

                },
                error: function (err) {

                }
            });
        });
    </script>
    <script>
        function changeRole() {
            var checkBox = document.getElementById('company');
            if (checkBox.checked === true) {
                $('.company').show();
                $('.personal').hide();
            } else {
                $('.company').hide();
                $('.personal').show();
            }
        }
        function setTab(name) {
            console.log(name);
            $('.tabHeader').removeClass('active');
            $('.tab-pane').removeClass('show').removeClass('active');
            $('#' + name + '-header').addClass('active');
            $('#' + name).addClass('show').addClass('active');
        }
        function initPhoneNumber(){
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                utilsScript: "{{ asset('plugins/input-int-telephone/js/utils.js') }}",
            });
            input.addEventListener('countrychange', function(e) {
                var dialCode = iti.getSelectedCountryData().dialCode;
                $("input[name=phone_prefix]").val(dialCode)
            });
        }

        $(function () {
            $('.js_select_category').select2();
            $('.js_select_language').select2();
            initPhoneNumber()
            changeRole();
            @if(session()->has('success'))
            $.notify({
                // options
                title: 'Successfully',
                message: 'Updated'
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
        })
    </script>
@endsection

