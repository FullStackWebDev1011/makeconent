@extends('layouts.auth')

@section('content')

<main>
    <div class="container-fluid">
        <div class="row ">
            <div class="col-lg-4  bg-white">
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
                        <div class="p-b-20 text-center">
                            <p>
                                <img src="{{asset('assets/img/logo-black.png')}}" width="200" alt="">
                            </p>
                        </div>
                        <h3 class="text-center p-b-20 fw-400">Login</h3>
                        <form class="needs-validation" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group floating-label col-md-12">
                                    <label>Email</label>
                                    <input type="email" required
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Email">

                                </div>
                                <div class="form-group floating-label col-md-12">
                                    <label>Password</label>
                                    <input type="password" required name="password"
                                        class="form-control @error('password') is-invalid @enderror">

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                        </form>
                        <p class="text-right p-t-10">
                            <a href="{{route('password.request')}}" class="text-underline">Forgot Password?</a>
                        </p>
                        <p class="text-center p-t-10">
                            {{__('main.dont_have_account')}}? <a class="text-underline" href="{{route('register')}}">
                                Sign Up </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
