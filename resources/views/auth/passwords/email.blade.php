@extends('layouts.auth')
@section('content')
<div class="container">
        <div class="row m-h-100 ">
            <div class="col-md-8 col-lg-4  m-auto">
                <div class="card shadow-lg ">
                    <div class="card-body ">
					    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class=" padding-box-2 ">
                            <div class="text-center p-b-20 pull-up-sm">

                                <div class="avatar avatar-lg">
                                    <span class="avatar-title rounded-circle bg-pink"> <i
                                                class="mdi mdi-key-change"></i> </span>
                                </div>

                            </div>
                            <h3 class="text-center">Reset Password</h3>
                            <form method="POST" action="{{ route('password.email') }}">
                                   @csrf
								<div class="form-group">
                                    <label>Email</label>
                                    
                                    <div class="input-group input-group-flush mb-3">
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror form-control-prepended"
                                               value="{{ old('email') }}" placeholder="yourmail@example.com" required autocomplete="email" autofocus>
                                      @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


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
                                    <button type="submit" class="btn text-uppercase btn-block  btn-primary">
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

@endsection
