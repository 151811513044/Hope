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
                        <a href="{{url('/dashboard')}}">
                            <img class="align-content" src="{{asset('images/hope-login.png')}}" alt="Logo Hope">
                        </a>
                    </div>
                </div>
                <div class="login-form">
                    <form action="{{ route('register') }}" method="post">
                        {{csrf_field()}}
                        <input name="role" type="text" class="form-control" hidden>
                        <div class="form-group">
                            <label>Nama</label>
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama" value="{{ old('nama') }}">
                            @error('nama')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>User Name</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="User Name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="city">Provinsi</label>
                            </div>
                            <div class="col-md-6">
                                <label for="city">Kota</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <select name="province" class="form-control @error('province') is-invalid @enderror">
                                    <option value="{{old('province')}}">--Provinsi--</option>
                                    @foreach($province as $prov => $value)
                                    <option value="{{$prov}}">{{$value}}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                <div class=" invalid-feedback">{{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <select name="city" class="form-control @error('city') is-invalid @enderror">
                                    <option value="{{old('city')}}">--Kota--</option>
                                </select>
                                @error('city')
                                <div class=" invalid-feedback">{{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <input name="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" placeholder="Address" value="{{ old('alamat') }}">
                            @error('alamat')
                            <div class=" invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>No HP</label>
                            <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone" value="{{ old('phone') }}">
                            @error('phone')
                            <div class=" invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Email address</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                            <div class=" invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                            <div class=" invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                            @error('password_confirmation')
                            <div class=" invalid-feedback">{{$message}}
                            </div>
                            @enderror
                        </div>
                        <input name="remember_token" type="text" class="form-control hidden" hidden>
                        <div class="checkbox">
                            <label>
                                <input name="check" type="checkbox" class="form-sontrol @error('check') is-invalid @enderror"><a href="#" class="text-info ml-2" style="text-decoration:underline;">Agree the terms and policy</a>
                            </label>
                            @error('check')
                            <div class=" invalid-feedback">You must agree before submitting.
                            </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection

    @section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name="province"]').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    jQuery.ajax({
                        url: '/provinsi/' + provinceId + '/cities',
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="city"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="city"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city"]').empty();
                }
            });
        });
    </script>
    @endsection