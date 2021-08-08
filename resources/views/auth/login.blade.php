@extends('auth.master')

@section('body')

<body class="bg-secondary">
    @endsection
    @section('content')
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <div class="content" style="background: linear-gradient(#75ab50, #fdfdfd);">
                        <a href="{{url('/')}}">
                            <img class="align-content" src="{{asset('images/hope-login.png')}}" alt="Logo Hope">
                        </a>
                    </div>
                </div>
                <div class="login-form">
                    @if(session('status'))
                    <div class="sufee-alert alert with-close alert-secondary alert-dismissible fade show">
                        {{ session('status') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <form action="{{ route('post-login') }}" method="post">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>Email address</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                            @error('email')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember Me</label>

                            <label class="pull-right">
                                @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgotten Password?</a>
                                @endif
                            </label>
                        </div>
                        @if(session('error'))
                        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                        <div class="social-login-content">
                            <div class="social-button">
                                <button type="button" class="btn btn-primary btn-flat btn-addon mt-2"><i class="ti-google"></i>Sign in with google</button>
                            </div>
                        </div>
                        <div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="{{ url('/register')}}"> Sign Up Here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection