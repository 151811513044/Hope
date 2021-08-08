<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            @if(Auth::user()->role == 'admin')
            <a class="navbar-brand" href="{{url('/dashboard')}}"><img src="{{ asset('images/hope-admin.png') }}" alt="Logo"></a>
            @endif
            @if(Auth::user()->role == 'mix')
            <a class="navbar-brand" href="{{url('/dashboard/seller')}}"><img src="{{ asset('images/hope-admin.png') }}" alt="Logo"></a>
            @endif
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="User Avatar">
                    <button class="btn btn-sm">{{auth()->user()->name}} </button>
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href=""><i class="fa fa-user"></i> Edit Profil</a>
                    <a class="nav-link" href="{{'/change-password'}}"><i class="fa fa-pencil"></i> Change Password</a>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="
                    event.preventDefault();
                    document.getElementById('formLogout').submit();">
                        <i class="fa fa-power-off"></i>Logout</a>
                    <form id="formLogout" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>