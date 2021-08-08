<nav class="navbar navbar-expand-sm navbar-default">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="menu-title" id="dashboard">
                @if(Auth::user()->role == 'admin')
                <a href="{{url('dashboard')}}" class="nav-link"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                @endif
                @if(Auth::user()->role == 'mix')
                <a href="{{url('/dashboard/seller')}}" class="nav-link"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                @endif
            </li>
            @if(auth()->user()->role == 'admin')
            <li class="menu-title">User</li><!-- /.menu-title -->
            <li class="">
                <a href="{{url('/admin')}}"> <i class="menu-icon fa fa-user"></i>Admin</a>
            </li>
            <li class="">
                <a href="{{url('/customer')}}"> <i class="menu-icon fa fa-user"></i>Customer</a>
            </li>
            <li class="">
                <a href="{{url('/store')}}"> <i class="menu-icon fa fa-user"></i>Store</a>
            </li>
            @endif
            <!-- <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Admin</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fa fa-sign-in"></i><a href="page-login.html">Data Admin</a></li>
                    <li><i class="menu-icon fa fa-sign-in"></i><a href="page-register.html">Add admin</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Customer</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fa fa-sign-in"></i><a href="#">Data Customer</a></li>
                    <li><i class="menu-icon fa fa-sign-in"></i><a href="#">Add Customer</a></li>
                </ul>
            </li>
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Store</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fa fa-sign-in"></i><a href="page-login.html">Data Store</a></li>
                    <li><i class="menu-icon fa fa-sign-in"></i><a href="page-register.html">Add Store</a></li>
                </ul>
            </li> -->
            <li class="menu-title"><img src="{{ asset('images/hope-market.png') }}" width="70px" alt="HopeMarket">Hope Market</li><!-- /.menu-title -->
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-book"></i>Catalog</a>

                <ul class="sub-menu children dropdown-menu">
                    @if(Auth::user()->role == 'mix')
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/product')}}/{{Auth::user()->id}}">Product</a></li>
                    @endif
                    @if(Auth::user()->role == 'admin')
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/product')}}">Product</a></li>
                    @endif
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/kategori')}}">Kategori Product</a></li>
                </ul>
            </li>
            <!-- Transaction -->
            @if(Auth::user()->role == 'admin')
            <li class="">
                <a href="{{url('/transaction')}}"> <i class="menu-icon fa fa-book"></i>Transaction</a>
            </li>
            @endif
            <!-- End Transaction -->
            <!-- History -->
            @if(Auth::user()->role == 'admin')
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>History</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/transaction/success')}}">Success</a></li>
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/transaction/failed')}}">Failed</a></li>
                </ul>
            </li>
            @endif
            @if(Auth::user()->role == 'mix')
            <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-book"></i>Laporan</a>
                <ul class="sub-menu children dropdown-menu">
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/transaction')}}/{{Auth::user()->id}}">Transaction</a></li>
                    <li><i class="menu-icon fa fa-circle-o"></i><a href="{{url('/report')}}">Revenue</a></li>
                </ul>
            </li>
            @endif
            <!-- End History -->
            @if(Auth::user()->role == 'admin')
            <li class="">
                <a href="{{url('/carousel')}}"><i class="menu-icon ti-layers"></i> Carousel</a>
            </li>
            @endif
            @if(Auth::user()->role == 'mix')
            <li class="">
                <a href="{{url('/carousel')}}/{{Auth::user()->id}}"><i class="menu-icon ti-layers"></i> Carousel Toko</a>
            </li>
            @endif
            @if(Auth::user()->role == 'mix')
            <li class="">
                <a href="{{url('/home')}}"><i class="menu-icon ti-shopping-cart"></i> Shop Now</a>
            </li>
            @endif
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>