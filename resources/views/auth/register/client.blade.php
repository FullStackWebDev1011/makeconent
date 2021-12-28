@extends('layouts.auth')
@section('content')
<style>
	.nopadding {
		padding: 0px !important;
	}

</style>
<main class="">
	<div class="container-fluid">
		<div class="row " style="background-image: url('{{asset("assets/img/auth.svg")}}');">
			<div class="col-lg-6  bg-white" style="margin:auto;">
				<div class="row align-items-center m-h-100">

					<div class="mx-auto col-md-8">
						@if ($errors->any())
						<div class="col-12 alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
						@endif
						<form class="needs-validation" action="{{route('register')}}" method="POST">
							@csrf
							<div class="p-b-20 text-center">
								<p>
									<a href="{{ url('/') }}">
										<img src="{{asset('assets/img/logo-black.png')}}" width="200" alt="">
									</a>
								</p>

							</div>
							<h3 class="text-center p-b-20 fw-400">{{__('main.register')}}</h3>
							<div class="m-b-10">
								<input type="hidden" name="code" value="{{$code}}">
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="userType1" name="userType" class="custom-control-input"
										value="client" @if(old('userType')=='client' || !old('userType')) checked
										@endif>
									<label class="custom-control-label" for="userType1">{{__('main.client')}}</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline">
									<input type="radio" id="userType2" name="userType" @if(old('userType')=='copywriter'
										) checked @endif class="custom-control-input" value="copywriter">
									<label class="custom-control-label"
										for="userType2">{{__('main.copywriter')}}</label>
								</div>
							</div>
							<div class=" m-b-10">
								<label class="cstm-switch">
									<input id="company" onclick="myFunction()" type="checkbox" name="isCompany"
										value="1" class="cstm-switch-input">
									<span class="cstm-switch-indicator "></span>
									<span class="cstm-switch-description">{{__('main.company_account')}}? </span>
								</label>

							</div>
							<div class="form-row">
								<div class="form-group floating-label col-md-6">
									<label>{{__('Name')}}</label>
									<input type="text" class="form-control @error('fname') is-invalid @enderror"
										value="{{old('fname')}}" required autocomplete="fname" name="fname"
										placeholder="{{__('Name')}}">
								</div>
								<div class="form-group floating-label col-md-6">
									<label>{{__('Surename')}}</label>
									<input type="text" class="form-control @error('name') is-invalid @enderror"
										value="{{old('lname')}}" required autocomplete="lname" name="lname"
										placeholder="{{__('Surname')}}">
								</div>


								<div class="form-group floating-label col-md-12">
									<label>Email</label>
									<input type="email" required
										class="form-control @error('email') is-invalid @enderror"
										value="{{old('email')}}" autocomplete="email" placeholder="Email" name="email">
								</div>
								<div class="form-group floating-label col-md-6">                                
									<label>Select Country</label>
									<select class="col-md-9 form-control js-select2" id="country" name="country" style="width: 200px" required>
										@foreach($countries as $key=>$country)
											<option value="{{$country->id}}">{{ $country->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group floating-label col-md-12">
									<label>Password</label>
									<input type="password" required
										class="form-control @error('password') is-invalid @enderror"
										autocomplete="new-password" placeholder="Password" id="password"
										name="password">
								</div>
							</div>
							<div class="form-group floating-label">
								<label>Password Again</label>
								<input type="password" class="form-control" required id="confirm_password"
									autocomplete="new-password" placeholder="Password Again"
									name="password_confirmation">
							</div>
							<div id="companyin" style="display:none;">
								<div class="form-group floating-label col-md-12 nopadding">
									<label>Company Name</label>
									<input type="text" class="form-control @error('companyName') is-invalid @enderror"
										value="{{old('companyName')}}" autocomplete="companyName" name="companyName"
										placeholder="Company Name">
								</div>
								<div class="form-group floating-label col-md-12 nopadding">
									<label>NIP</label>
									<input type="NIP" class="form-control @error('vat_number') is-invalid @enderror"
										value="{{old('vat_number')}}" autocomplete="NIP" placeholder="VAT Number"
										name="vat_number">
								</div>


								<div class="form-row">
									<div class="form-group floating-label col-md-6">
										<label>Street</label>
										<input type="text" class="form-control @error('street') is-invalid @enderror"
											value="{{old('street')}}" autocomplete="address" placeholder="Street"
											name="street">
									</div>

									<div class="form-group floating-label col-md-6">
										<label>Apartament Number</label>
										<input type="text"
											class="form-control @error('apartment_number') is-invalid @enderror"
											name="apartment_number" value="{{old('apartment_number')}}"
											autocomplete="Apartment Number" placeholder="Apartament Number">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group floating-label col-md-6">
										<label>City</label>
										<input type="text" class="form-control @error('city') is-invalid @enderror"
											value="{{old('city')}}" autocomplete="city" placeholder="City" name="city">
									</div>

									<div class="form-group floating-label col-md-6">
										<label>Zip-Code</label>
										<input type="text" class="form-control @error('post_code') is-invalid @enderror"
											value="{{old('post_code')}}" autocomplete="zip" placeholder="Zip"
											name="post_code">
									</div>
								</div>
							</div>
							<div class="input-group" id="other" style="display: none">
								<label>Write Sample text (min 700 characters with spaces)</label><br>
								<textarea class="form-control @error('request_string') is-invalid @enderror"
									name="request_string" style="min-width:12rem;" aria-label="Keyword: SEO">
								</textarea>
							</div>
							<br>

							<p class="">
								<label class="cstm-switch">
									<input type="checkbox" checked name="terms" value="1" class="cstm-switch-input">
									<span class="cstm-switch-indicator "></span>
									<span class="cstm-switch-description"> I agree to the Terms and Privacy. </span>
								</label>
							</p>
							<button type="submit" class="btn btn-primary btn-block btn-lg">Create Account</button>
						</form>
						<p class="text-right p-t-10">
							<a href="{{route('login')}}" class="text-underline">Already a user?</a>
						</p>
					</div>

				</div>
			</div>

		</div>
	</div>
</main>

@endsection

@section('script')
<script>
	$(function () {
		var userType = "{{ old('userType') ?? 'client'}}";
		toggleOther(userType);
		$("input[name='userType']").change(function () {
			toggleOther($(this).val());
		});
	});

	function toggleOther(userType) {
		if (userType === 'client') {
			$('#other').hide();
		} else {
			$('#other').show();
		}
	}

	function myFunction() {
		// Get the checkbox
		var checkBox = document.getElementById("company");
		// Get the output text
		var text = document.getElementById("companyin");

		// If the checkbox is checked, display the output text
		if (checkBox.checked == true) {
			text.style.display = "block";
		} else {
			text.style.display = "none";
		}
	}

</script>
@endsection
