@extends('layouts.frontend')

<title>Login</title>
<meta charset="UTF-8">
<meta name="description" content="Login">
<meta name="keywords" content="login, sign">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
{{ App::setLocale(session()->get('locale') ? session()->get('locale')  : "en") }}
@section('content')

<div class="card col-lg col-xl-9 flex-row mx-auto px-0">
    <div class="img-left d-none d-md-flex"></div>

    <div class="card-body">
        <h4 class="title text-center mt-2 mb-3">{{ trans('frontend.Aleardy have an account?') }}{{ trans('frontend.Sign In') }}</h4>
        <form class="form-box px-3"method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-input">
                <span><i class="fa fa-envelope"></i></span>
                <input type="email" name="email" placeholder="{{ trans('frontend.Email') }}" tabindex="10" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>

                @error('email')
                    <span class="invalid-feedback mt-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-input">
                <span><i class="fa fa-key"></i></span>
                <input type="password" name="password" placeholder="{{ trans('frontend.Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                 @error('password')
                    <span class="invalid-feedback mt-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="remember">{{ trans('frontend.Remember me') }}</label>
              </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-block">{{ trans('frontend.Sign In') }}</button>
            </div>
            <div class="text-right">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forget-link">{{ trans('frontend.Forgot Password?') }}</a>
                @endif
          </div>
<!--  
            <div class="text-center mb-3">
                or login with
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <a href="/login/facebook" class="btn btn-block btn-social btn-facebook">Facebook</a>
                </div>
                <div class="col-6">
                    <a href="/login/google" class="btn btn-block btn-social btn-google">Google</a>
                </div>
            </div>
-->
            <hr class="my-4"></hr>

            <div class="text-center mb-2">
            {{ trans('frontend.Dont have an account?') }}
                <a href="{{ route('register') }}" class="register-link">{{ trans('frontend.Sign Up') }}</a>
            </div>
        </form>
    </div>
    
</div>
@endsection

