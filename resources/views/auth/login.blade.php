@extends('layouts.auth')
@section('titulo', 'Login')
@section('container')

<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card">

            <div class="card-header pt-4 pb-4 text-center bg-primary">
                <a href="index.html">
                    <span><img src="{{ asset('logo-general.svg') }}" alt="" height="42"></span>
                </a>
            </div>

            <div class="card-body p-4">

                <div class="text-center w-75 m-auto">
                    <h4 class="text-dark-50 text-center mt-0 font-weight-bold">Sign In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access admin panel.
                    </p>
                </div>

                <form method="POST" action="{{ route('login') }}" onsubmit="return checkSubmit();">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" oninput="this.value=this.value.toLowerCase();removeSpaces(this);" autocomplete="off" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" oninput="removeSpaces(this);" placeholder="********" autocomplete="password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary reveal-password" type="button">
                                    <i class="mdi mdi-eye-off-outline" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="remember">{{ __('Remember me') }}</label>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary" id="btn-free" type="submit">{{ __('Log in') }}</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection