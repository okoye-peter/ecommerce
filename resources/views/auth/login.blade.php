@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="row m-0 justify-content-center mt-4">
    @if (session()->has('success'))
      <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="alert alert-success alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{session('success')}}
        </div>
      </div>
    @endif
    @error('error')
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="alert alert-danger alert-dismissible fade show">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{$message}}
        </div>
      </div>
    @enderror

    <div class="card card-primary shadow mx-auto">
      <div class="card-header text-center">
        <h4>{{ __('Login') }}</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
          @csrf
          <div class="form-group mb-4">
            <label for="email">{{ __('E-Mail Address') }}</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" value="{{ old('email') }}" autofocus="">
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="form-group mb-4">
            <div class="d-block">
              <label for="password" class="control-label">{{ __('Password') }}</label>
              <div class="float-right">
                <a href="{{ route('password.request') }}" class="text-small">
                  {{ __('Forgot Your Password?') }}
                </a>
              </div>
            </div>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2">
            @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
              <label class="custom-control-label" for="remember-me">Remember Me</label>
            </div>
          </div>
          <div class="form-group">

            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
              Login
            </button>
          </div>
        </form>
        <div class="text-center mt-4 mb-3">
          <div class="text-job text-muted">Login With Social</div>
        </div>
        <div class="row sm-gutters mx-0 mb-1">
          <div class="col-6 pl-0">
            <a class="btn btn-block btn-social btn-facebook">
              <span class="fab fa-facebook"></span> Facebook
            </a>
          </div>
          <div class="col-6 pr-0">
            <a class="btn btn-block btn-social btn-twitter">
              <span class="fab fa-twitter"></span> Twitter
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-5 text-muted text-center w-100">
      Don't have an account? <a href="{{ route('register') }}">Create One</a>
    </div>
  </div>
@endsection
