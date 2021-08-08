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
                        <a href=" {{url('/dashboard')}}">
                            <img class="align-content" src="{{asset('images/hope-login.png')}}" alt="Logo Hope">
                        </a>
                    </div>
                </div>
                <div class="login-form">
                    @foreach($seller as $sell)
                    <form action="{{ url('/register')}}/{{$sell->id}}" method="post">
                        {{csrf_field()}}
                        @method('patch')
                        <input name="role" type="text" class="form-control" hidden>
                        <div class="form-group">
                            <label>Nama Toko</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Toko" value="{{ old('name') }}">
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
                                    <option value="">--Provinsi--</option>
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
                                    <option value="">--Kota--</option>
                                </select>
                                @error('city')
                                <div class=" invalid-feedback">{{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
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
                        <input name="remember_token" type="text" class="form-control hidden" hidden>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"><a href="#" class="text-info ml-2" style="text-decoration:underline;">Agree the terms and policy</a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                    </form>
                    @endforeach
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
                        url: '/provinsi/' + provinceId + '/kota',
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