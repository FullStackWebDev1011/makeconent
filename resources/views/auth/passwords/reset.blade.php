@extends('layouts.auth')

@section('content')

    <div class="container">
        <div class="row m-h-100 ">
            <div class="col-md-8 col-lg-4  m-auto">
                <div class="card shadow-lg ">
                    <div class="card-body ">
                        <div class=" padding-box-2 ">
                            <div class="text-center p-b-20 pull-up-sm">

                                <div class="avatar avatar-lg">
                                    <span class="avatar-title rounded-circle bg-pink"> <i
                                                class="mdi mdi-key-change"></i> </span>
                                </div>

                            </div>
                            <h3 class="text-center">Reset Password</h3>
                            <form action="index.html" method="post">
                                <div class="form-group">
                                    <label>Email</label>

                                    <div class="input-group input-group-flush mb-3">
                                        <input type="email" class="form-control form-control-prepended"
                                               placeholder="yourmail@example.com">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <span class=" mdi mdi-email "></span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="small">
                                        We will send a reset link to your registered E-Mail
                                    </p>
                                </div>


                                <div class="form-group">
                                    <button class="btn text-uppercase btn-block  btn-primary">
                                        Reset Password
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">LUL</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
