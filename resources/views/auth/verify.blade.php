@extends('auth.master')

@section('body')

<body class="bg-light">
    @endsection

    @section('content')

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="{{url('/')}}">
                        <img class="align-content" src="{{asset('images/logo-hope.png')}}" width="150px" alt="Logo Hope">
                    </a>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card border border-secondary">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection