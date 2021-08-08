<!-- header start -->
<header>
    <div class="header-top-furniture wrapper-padding-2 res-header-sm">
        <div class="container-fluid" style="background: linear-gradient(#75ab50, #fdfdfd);">
            <div class="header-bottom-wrapper">
                <div class="logo-2 furniture-logo ptb-30">
                    <a href="/home">
                        <!-- 180 x 45 -->
                        <img src="{{ asset('themes/ezone/assets/img/logo/2.png') }}" width="250px" alt="">
                    </a>
                </div>
                <div class="furniture-search mt-2">
                    <br>
                    <form action="{{url('/home/products')}}" method="get">
                        <input class="form-control" placeholder="I am Searching for . . ." type="text" name="q" value="{{$q}}">
                        <button>
                            <i class="ti-search"></i>
                        </button>
                    </form>
                </div>
                <?php

                use Illuminate\Support\Facades\Auth;

                $transaction = \App\Models\Transaction::where('cust_id', Auth::user()->cust_id)->where('is_cart', 0)->first();
                $trans = \App\Models\Transaction::where('cust_id', Auth::user()->cust_id)->where('is_cart', 1)->first();
                if ($transaction) {
                    $notif = \App\Models\TransactionDetail::where('transaction_id', $transaction->id_transaksi)->count();
                }
                ?>
                @if($transaction == null && $trans == null)
                <a class="icon-cart-furniture" href="{{url('/cart')}}">
                    <i class="ti-shopping-cart"></i>
                </a>
                @endif
                @if($trans)
                <a class="icon-cart-furniture" href="{{url('/checkout')}}/{{$trans->id_transaksi}}">
                    <i class="ti-shopping-cart"></i>
                </a>
                @endif
                @if($transaction)
                <a class="icon-cart-furniture" href="{{url('/cart')}}">
                    <i class="ti-shopping-cart"></i>
                    <span class="shop-count-furniture green">{{$notif}}</span>
                </a>
                @endif
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
                        <li><a href="{{route('register')}}">Regist </a></li>
                        @endif
                        @if(auth()->user())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="ti-user"></i> {{auth()->user()->name}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"><i class="ti-pencil"></i> Edit Profile</a>
                                <a class="dropdown-item" href="{{'/change-password'}}"><i class="ti-unlock"></i> Change Password</a>
                                <a class="dropdown-item" href="{{url('/history')}}"><i class="ti-back-left"></i> History</a>
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
                        @if(auth()->user()->role != 'admin')
                        <li><a href="{{url('/konfirmasi')}}/{{Auth::user()->id}}"><i class="ti-package"></i> Konfirmasi Pembayaran</a></li>
                        @endif
                        @if(auth()->user()->role == 'customer')
                        <li><a href="{{ url('/register')}}/{{Auth::user()->id}}"><i class="ti-id-badge"></i> Seller</a></li>
                        @endif
                        @if(auth()->user()->role == 'mix')
                        <li><a href="{{url('/dashboard/seller')}}"><i class="ti-id-badge"></i>{{$seller->name}}</a> | <a href="{{url('/home/stores')}}/{{$seller->id}}" class="text-success">Toko</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header end -->

<!-- <div class="modal fade show" id="confirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Invoice ID</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ url('/product')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}
                    <button type="button" class="btn btn-primary btn-sm" style="float:right" id="upload"><span style="color:#fff"><i class="fa fa-plus"></i></span></button>
                    <br></br>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Nama Pemesan</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" value="{{ old('name')}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control" value="{{ old('email')}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">No HP</label>
                        <div class="col-sm-8">
                            <input type="number" name="phone" class="form-control" value="{{ old('email')}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label" id="label-upload">Bukti Pembayaran</label>
                        <div class="col-sm-8">
                            <input type="file" name="photo[]" class="" accept="./image" required><br>
                            <small>format: .jpg, .jpeg, .,png</small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary">Submit</a>
                    </form>
            </div>
        </div>
    </div>
</div> -->