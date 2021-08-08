@extends('auth.master')
@section('body')

<body class="bg-secondary">
    @endsection
    @section('content')

    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="{{url('/dashboard')}}">
                        <img class="align-content" src="{{asset('images/logo-hope.png')}}" width="150px" alt="Logo Hope">
                    </a>
                </div>
                @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{session('success')}}
                </div>
                @endif
                <div class="login-form">
                    <form action="{{ route('update-password') }}" method="post">
                        {{csrf_field()}}
                        @method('patch')
                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password">
                            @error('old_password')
                            <div class="invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-grup">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                            <div class="invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection