@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="section-title-6 text-left">
        <h2><i class="ti-shopping-cart"></i>Order History</h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Tanggal Pemesanan</th>
                        <th>Total Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaction_detail as $td)
                    <tr>
                        <td>{{$loop->iteration}}</td>
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
                        <td>{{$td->quantity}}</td>
                        <td>{{date('d F Y', strtotime($td->transaction->tanggal))}}</td>
                        <td>Rp. {{number_format($td->total_harga)}}</td>
                        <td align="center">
                            @if($td->transaction->is_cart == 3)
                            <!-- <form action="{{ url('/status/')}}/{{$td->transaction_id_transaksi}}" method="post" class="d-inline">
                                @csrf
                                @method('patch')
                                <button class="btn btn-outline-success btn-sm" onclick="return confirm('Apakah anda yakin product sudah di terima ?')">
                                    Pesanan Diterima
                                </button>
                            </form> -->
                            @if($td->is_review == null)
                            <a href="https://api.whatsapp.com/send?phone={{$td->transaction->phone}}" class="btn btn-outline-success btn-sm">Ajukan Pengembalian</a>
                            <a class="btn btn-primary btn-sm btn-hover" id="after" data-toggle="modal" href="#review-{{$td->id_transaction_detail}}">
                                Review
                            </a>
                            @endif
                            @if($td->is_review == 1)
                            <a href="{{url('product/'. $td->product->slug.'/'.$td->product->id_product)}}" class="btn btn-success btn-sm"><i class="ti-tag"></i> Pesan Lagi</a>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr align="center">
                        <td colspan="4"><a href="/home/products" class="btn btn-success">Mulai Belanja</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($transaction_detail as $td)
<!-- Modal Review -->
<div class="modal fade" id="review-{{$td->id_transaction_detail}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/review')}}/{{$td->id_transaction_detail}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="">Review or Comment</label>
                        <textarea class="form-control" name="comment" id="" cols="30" rows="10" placeholder="Review or Comment Here" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Foto</label>
                        <input type="file" accept="image/*" class="form-control" name="photo">
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
@endsection

@section('script')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')

@endsection