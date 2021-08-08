@extends('layouts.app')

@section('content')

<div class="popular-product-area wrapper-padding-3">
    <div class="container-fluid">
        <div class="section-title-6 text-left">
            <h2>Konfirmasi Pembayaran</h2>
        </div>
        @if($transaction->is_cart == 2)
        <div class="row mb-3">
            <!-- <div class="col-md-4">
                <select name="" id="" class="form-control">
                    <option value="">UUID</option>
                </select>
            </div> -->
            <!-- <div class="col-md-4">
                <button class="submit contact-btn btn-hover btn-sm text-sm-center" style="height:40px;">Pilih</button>
            </div> -->
            <div class="col-md-4"></div>
        </div>
        <!-- Pilih dulu Baru Keluar Data -->
        <div class="row">
            <div class="col-md-7">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="">Invoice ID</label>
                        <input type="text" class="fomr-control bg-light" value="{{$transaction->uuid}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7">
                        <label for="">Nama Pemesan</label>
                        <input type="text" class="fomr-control bg-light" value="{{$transaction->name}}" readonly>
                    </div>
                    <div class="col-md-5">
                        <label for="">No. HP Pemesan</label>
                        <input type="text" class="fomr-control bg-light" value="{{$transaction->phone}}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-9">
                        <label for="">Alamat</label>
                        <input type="text" class="fomr-control bg-light" value="{{$transaction->alamat}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="">Kota</label>
                        <input type="text" class="fomr-control bg-light" value="{{$transaction->city->name}}" readonly>
                    </div>
                </div>
                <form action="{{url('/bayar')}}/{{$transaction->id_transaksi}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Upload Bukti Pembayaran</label>
                        <input type="file" name="upload" class="form-control-file bg-light" accept="image/*">
                        <small>format: .jpg, .jpeg, .png</small>
                    </div>
                    <div class="form-group row justify-content-center">
                        <div class="col-md-6">
                            <button type="submit" class="submit contact-btn btn-hover btn-block">Submit</button>
                        </div>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <div class="your-order">
                <h3>Order Detail</h3>
                <div class="your-order-table table-hover table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction_detail as $td)
                            <tr class="cart_item">
                                <td>{{$td->product->nama_product}}</td>
                                <td>{{$td->quantity}}</td>
                                <td>{{$td->total_harga}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="cart-subtotal">
                                <th>Cart Subtotal</th>
                                <td><span class="amount">£215.00</span></td>
                            </tr>
                            <tr class="order-total">
                                <th>Order Total</th>
                                <td><strong><span class="amount">£215.00</span></strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <div class="card">
                <card class="body text-md-center p-2">
                    <h5 class="card-text">Belum Melakukan Pemesanan, Silahkan Memesan Product Terlebih Dahulu</h5>
                    <a href="{{url('/home')}}" class="btn-hover submit contact-btn btn-sm">Mulai Belanja</a>
                </card>
            </div>
        </div>
    </div>
    @endif
</div>
</div>

@endsection