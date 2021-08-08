@extends('auth.master')

@section('body')

<body class="bg-light">
    @endsection

    @section('content')

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="{{url('/home')}}">
                        <img class="align-content" src="{{asset('images/logo-hope.png')}}" width="150px" alt="Logo Hope">
                    </a>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card border border-secondary">
                            <div class="card-header">{{ __('Bill Payment has Sent to Your Email Address') }}</div>

                            <div class="card-body">
                                @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                                @endif

                                {{ __('Before paying, please check your email for a information about your order and payment account (rekening).') }}<br>
                                {{ __('Thank you and enjoy your shopping') }},
                                <a href="{{url('/home')}}" class="text-success"> back to shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection