@extends('layouts.app')

@section('css')
<!-- x editable -->
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet" />
@endsection

@section('content')
<div class="container-fluid p-4">
    <div class="section-title-6 text-left">
        <h2><i class="ti-shopping-cart"></i> Shopping Cart</h2>
    </div>
    <div class="row">
        <div class="col-xl-7">
            <!-- product area start -->
            <div class="popular-product-area ">
                <div class="container-fluid">
                    <div class="d-inline section-title-6 text-left mb-50">
                        <h4 class="d-inline-block">More Product</h4>
                    </div>
                    <div class="custom-row">
                        @foreach($products as $prod)
                        <div class="custom-col-5  mb-95">
                            @php
                            $i= 1
                            @endphp
                            <div class="product-wrapper {{$i}}">
                                <div class="product-img text-center">
                                    @if(!Auth::user())
                                    <a href="{{ url('product/'. $prod->slug.'/'.$prod->id_product) }}">
                                        @if ($prod->galleries->first())
                                        <img src="{{ asset('storage/images/product/'.$prod->galleries->first()->photo) }}" style="width:130px; height:141px; object-fit:contain;" alt="{{ $prod->nama_product }}">
                                        @else
                                        <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $prod->nama_product }}">
                                        @endif
                                    </a>
                                    @endif
                                    @if(Auth::user())
                                    <a href="{{ url('home/product/'. $prod->slug.'/'.$prod->id_product) }}">
                                        @if ($prod->galleries->first())
                                        <img src="{{ asset('storage/images/product/'.$prod->galleries->first()->photo) }}" style="width:130px; height:141px; object-fit:contain;" alt="{{ $prod->nama_product }}">
                                        @else
                                        <img src="{{ asset('themes/ezone/assets/img/product/fashion-colorful/2.jpg') }}" alt="{{ $prod->nama_product }}">
                                        @endif
                                    </a>
                                    @endif
                                </div>
                                <div class="product-content-2 text-center">
                                    <h4>{{$prod->nama_product}}</h4>
                                    <p>{{$prod->store->city->name}}</p>
                                    <span>Rp. {{number_format($prod->harga_product)}}</span>
                                </div>
                            </div>
                            @php
                            $i++
                            @endphp
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- product area end -->
        </div>
        <div class="col-sm-5">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($transaction)
                    @forelse($transaction_detail as $td)
                    <tr>
                        <td style="width:10%;" class="product-remove">
                            <a href="{{url('/cart/delete/'.$td->id_transaction_detail)}}" onclick="return confirm('Apakah anda yakin ingin menghapus ini ?')">
                                <i class="ti-close"></i>
                            </a>
                        </td>
                        <td>
                            <ul>
                                <li class="single-product-cart">
                                    <div class="cart-img">
                                        <a href=""><img src="{{ asset('storage/images/product/'.$td->product->galleries->first()->photo) }}" style="width:80px; height:101px; object-fit:contain;" alt=""></a>
                                    </div>
                                    <div class="cart-title">
                                        <h5>{{$td->product->nama_product}}</h5>
                                        <span>Toko : <a href="#" class="text-success">{{$td->product->store->name}}</a></span>
                                        <span>@Rp.{{number_format($td->product->harga_product)}}</span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                        <td align="center">
                            @if($td->product->stock_product > 0)
                            <a href="#qty-{{$td->id_transaction_detail}}" class="btn-outline-primary" data-toggle="modal">{{$td->quantity}}</a>
                            @else
                            <span class="text-danger">Stock Product Habis</span>
                            @endif
                        </td>
                        <td>Rp. {{number_format($td->total_harga)}}</td>
                    </tr>
                    @empty
                    <tr align="center">
                        <td colspan="4"><a href="/home/products" class="btn btn-success">Mulai Belanja</a></td>
                    </tr>
                    @endforelse
                    <tr style="height:10%">
                        <td align="right" colspan="3">
                            <h5>Total Harga</h5>
                        </td>
                        <td>Rp. {{number_format($subtotal)}}</td>
                    </tr>
                    <tr align="center" style="height:10%">
                        <td colspan="4"><a href="{{url('checkout')}}/{{$transaction->id_transaksi}}" class="btn btn-primary"><i class="ti-shopping-cart-full"></i> CheckOut</a></td>
                    </tr>
                    @else
                    <tr class="text-center">
                        <td colspan="5" style="padding:30%">
                            <h4>Belum ada Product di Keranjang</h4>
                            <a href="{{url('/home')}}" class="submit contact-btn btn-sm text-light btn-hover"><i class="ti-shopping-cart"></i> Mulai Belanja</a>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($transaction)
@foreach($transaction_detail as $td)
<!-- Modal Update Qty -->
<div class="modal fade" id="qty-{{$td->id_transaction_detail}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Quantity</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/cart/quantity')}}/{{$td->id_transaction_detail}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="">Product</label>
                        <input type="text" value="{{$td->product->nama_product}}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="qty" class="form-control" value="{{$td->quantity}}" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary">Submit</a>
                    </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
@endsection

@section('script')
<!-- x editable -->
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script>
    $(document).ready(function() {
        $('.quantity').editable();
    });
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')
@endsection