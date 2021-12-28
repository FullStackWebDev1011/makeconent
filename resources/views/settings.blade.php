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
                                    <form action="{{ route('settings.client.save') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <h3 class="">Personal Data</h3>
                                        <p class="text-muted">
                                            Use this page to update your contact information and change your password.
                                        </p>
                                        <div class="">
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
                                            <div class="form-group">
                                                <label class="cstm-switch">
                                                    <input id="company" onclick="changeRole()" type="checkbox" value="1"
                                                           name="isCompany" @if(old('isCompany') ?? $user->isCompany) checked
                                                           @endif class="cstm-switch-input">
                                                    <span class="cstm-switch-indicator "></span>
                                                    <span class="cstm-switch-description">{{__('main.company_account')}}? </span>
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
                                                       >
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
                                                <!-- <input type="number" class="form-control" placeholder="Phone number"
                                                       value="{{ old('phone') ?? $user->phone }}" name="phone"
                                                       autocapitalize="phone" required> -->
                                                <input type="hidden"  name="phone_prefix" value="{{ old('phone_prefix') ?? $user->phone_prefix }}">
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
                                            <input type="text" class="form-control" name="companyName"
                                                   placeholder="Company Name"
                                                   value="{{ old('companyName') ?? $user->companyName }}">
                                            @error('companyName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-row company">
                                            <div class="col-md-6 form-group">
                                                <label for="inputAddress2">Street <span class="text-red">*</span></label>
                                                <input type="text" name="comp_street" class="form-control" placeholder="Street"
                                                       value="{{ old('comp_street') ?? $user->comp_street }}">
                                                @error('comp_street')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="inputAddress2">Apartment Number <span class="text-red">*</span></label>
                                                <input type="text" name="comp_apartment_number" class="form-control"
                                                       placeholder="Apartment Number"
                                                       value="{{ old('comp_apartment_number') ?? $user->comp_apartment_number }}">
                                                @error('comp_apartment_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row company">
                                            <div class="col-md-6 form-group">
                                                <label for="inputAddress2">City <span class="text-red">*</span></label>
                                                <input type="text" name="comp_city" class="form-control" placeholder="City"
                                                       value="{{ old('comp_city') ?? $user->comp_city }}">
                                                @error('comp_city')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="inputAddress2">Post Code <span class="text-red">*</span></label>
                                                <input type="number" name="comp_post_code" class="form-control"
                                                       placeholder="Post Code"
                                                       value="{{ old('comp_post_code') ?? $user->comp_post_code }}">
                                                @error('comp_post_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-row personal">
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
                                        <div class="form-row personal">
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
                                                <input type="text" name="post_code" class="form-control"
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
                                                <label for="inputPassword4">VAT Number <span class="text-red">*</span></label>
                                                <input type="text" class="form-control" placeholder="VAT Number"
                                                       value="{{ old('vat_number') ?? $user->vat_number }}"
                                                       name="vat_number">
                                                @error('vat_number')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>

                                        </div>

                                        <button type="submit" class="btn btn-success btn-cta">Save changes</button>
                                    </form>
                            </div>
                        </div>
                    </div>
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
                                <h3>Your Account Status</h3>
                                <p class="text-muted">
                                    If you want change your type of account, write to support
                                </p>
                                <div class="row">
                                    <div class="col-sm-4 m-b-30">
                                        <div class="option-box-grid d-block">
                                            <input id="check1"
                                                   @if($user->role() === 'freelancer') checked @endif
                                                   value="copywriter" name="userType" type="radio" disabled>
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
                                            name="userType" value="client" type="radio" disabled>
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
                                            <input id="check2" value="company" name="userType" type="radio" disabled>
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
			<div class="col-md-12">
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
                    </div>			
                </div>

            </div>

        </section>
    </section>
@endsection

@section('script')
    <script src="{{asset('plugins/input-int-telephone/js/intlTelInput.min.js')}}"></script>
    <script src="{{asset('plugins/input-int-telephone/js/intlTelInput-jquery.min.js')}}"></script>
    <script src="{{asset('assets/vendor/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/js/setting-data.js')}}"></script>
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
            changeRole();
            initPhoneNumber();
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

