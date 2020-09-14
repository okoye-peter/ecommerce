@extends('layouts.app')

@section('css')
    <style>
        button{
            background: #18366f;
            padding: 0.5em;
            color: white;
            border: 0;
            outline: none;
            font-size: 16px;font-weight: 600;
            /* margin-right: 7em; */
            border-radius: 1em;
        }
        button:hover{
            border: 2px solid #18366f;
            background-color: transparent;
            color: #18366f;
            outline: none;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div> --}}
            <div class="shadow-sm bg-white p-3 my-5">
                <div class="d-flex justify-content-center">
                    <img src="{{asset('image/logo.png')}}" alt="">
                </div>
                <h3 class="text-center my-3" style="color:#03122e;border-bottom: 1px solid #03122e">{{ __('Verify Your Email Address') }}</h3>
                <p class="text-center">
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                </p>
                <p class="text-center mb-4">
                    {{ __('If you did not receive the email.') }}
                </p>
                  <form action="{{ route('verification.resend') }}" method="post" class="d-flex justify-content-center">
                    @csrf
                    <button type="submit">{{ __('click here to request another') }}</button>.
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
