<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Hope Market - eCommerce</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo-hope.png') }}">

    <!-- all css here -->
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/pe-icon-7-stroke.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/icofont.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/easyzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/meanmenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/ezone/assets/css/responsive.css') }}">
    <script src="{{ asset('themes/ezone/assets/js/vendor/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- header start -->
    <header>
        <div class="header-top-furniture wrapper-padding-2 res-header-sm">
            <div class="container-fluid" style="background: linear-gradient(#75ab50, #fdfdfd);">
                <div class="header-bottom-wrapper">
                    <div class="logo-2 furniture-logo ptb-30">
                        <a href="/">
                            <img src="{{ asset('themes/ezone/assets/img/logo/2.png') }}" alt="">
                        </a>
                    </div>
                    <div class="furniture-search mt-2">
                        <br>
                        <form action="{{url('/products')}}" method="get">
                            <input class="form-control" placeholder="I am Searching for . . ." type="text" name="q" value="{{$q}}">
                            <button>
                                <i class="ti-search"></i>
                            </button>
                        </form>
                    </div>
                    <a class="icon-cart-furniture" href="{{url('/cart')}}">
                        <i class="ti-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-bottom-furniture wrapper-padding-2 border-top-3">
            <div class="container-fluid">
                <div class="furniture-bottom-wrapper">
                    <div class="furniture-login">
                        <ul>
                            @if(!auth()->user())
                            <li>Get Access: <a href="{{route('login')}}">Login </a></li>
                            <li><a href="{{route('register')}}">Registrasi </a></li>
                            @endif
                            @if(auth()->user())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti-user"></i> {{auth()->user()->name}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#"><i class="ti-pencil"></i> Edit Profile</a>
                                    <a class="dropdown-item" href="{{'/change-password'}}"><i class="ti-unlock"></i> Change Password</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="
                                    event.preventDefault();
                                    document.getElementById('formLogout').submit();"><i class="ti-power-off"></i> Logout</a>
                                    <form id="formLogout" action="{{ route('logout') }}" method="post">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="furniture-wishlist">
                        <ul>
                            @if(!auth()->user())
                            <li><a href="#"><i class="ti-package"></i> Konfirmasi Pembayaran</a></li>
                            @endif
                            @if(!auth()->user())
                            <li><a href="{{route('register')}}"><i class="ti-id-badge"></i> Seller</a></li>
                            @endif
                            @if(auth()->user())
                            <li><a href="{{ url('/register')}}/{{Auth::user()->id}}"><i class="ti-id-badge"></i> Seller</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header end -->

    @yield('content')

    @include('layouts.includes.footer')

    @yield('modals')

    <!-- all js here -->
    <script src="{{ asset('themes/ezone/assets/js/vendor/jquery-1.12.0.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/popper.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/ajax-mail.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('themes/ezone/assets/js/main.js') }}"></script>
</body>

</html>