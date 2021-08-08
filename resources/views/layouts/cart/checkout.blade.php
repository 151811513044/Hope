@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">
    <div class="section-title-6 text-left">
        <h2><i clas=""></i> Checkout</h2>
        <h6>ID Pesanan : {{$transaction->uuid}}</h6>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-borderless table-hover">
                <tbody>
                    @forelse($transaction_detail as $td)
                    <tr>
                        <td style="width:10%;" id="no">{{$loop->iteration}}</td>
                        <td>
                            <ul>
                                <li class="single-product-cart">
                                    <div class="cart-img">
                                        <a href=""><img src="{{ asset('storage/images/product/'.$td->product->galleries->first()->photo) }}" style="width:80px; height:101px; object-fit:contain;" alt=""></a>
                                    </div>
                                    <div class="cart-title">
                                        <h5>{{$td->product->nama_product}}</h5>
                                        <span>Toko : <a href="#" class="text-success">{{$td->product->store->name}}</a></span>
                                        <span>@Rp.{{number_format($td->product->harga_product)}} x {{$td->quantity}}</span>
                                    </div>
                                </li>
                            </ul>
                        </td>
                        <td align="center" style="width:20%">
                            <span>Berat : {{($td->product->berat * $td->quantity)/1000}} Kg</span>
                            <input type="hidden" value="{{$td->product->id_product}}" name="id">
                            <input type="hidden" value="{{$td->product->store->city_id}}" id="origin" name="origin">
                            <input type="hidden" value="{{$td->transaction->city_id}}" id="destination" name="destination">
                            <input type="hidden" value="{{$td->product->berat * $td->quantity}}" id="weight" name="weight">
                            <select name="courier" id="courier" class="select-option-part">
                                <option value="{{old('courier')}}">- Pilih Kurir -</option>
                                @foreach($couriers as $courier)
                                <option value="{{$courier->code}}">{{$courier->name}}</option>
                                @endforeach
                            </select>
                            <!-- <div class="ongkir" id="ongkir"></div> -->
                            <select name="ongkir" id="ongkir" hidden>
                                <option value="">- Pilih Layanan -</option>
                            </select>
                        </td>
                        <td>Rp. {{number_format($td->total_harga)}}</td>
                    </tr>
                    @empty
                    <a href="/home/products" class="btn btn-info">Mulai Belanja</a>
                    @endforelse
                    <tr style="height:10%">
                        <td align="right" colspan="3">
                            <h5>Sub Total :</h5>
                        </td>
                        <td>Rp. {{number_format($subtotal)}}</td>
                    </tr>
                    <tr style="height:10%">
                        <td align="right" colspan="3">
                            <h5>Tax 10% :</h5>
                        </td>
                        <td>Rp. {{number_format($tax)}}</td>
                    </tr>
                    <tr style="height:10%">
                        <td align="right" colspan="3">
                            <h5>Ongkir :</h5>
                        </td>
                        <td>Rp. {{number_format($tax)}}</td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3">
                            <h3>Total Transaksi :</h3>
                        </td>
                        <td>Rp. {{number_format($td->transaction->total_transaksi)}}</td>
                    </tr>
                    <tr align="center">
                        <td colspan="4"><a href="{{url('bayar')}}/{{$td->transaction->id_transaksi}}" class="submit contact-btn btn-sm text-light btn-hover">Buat Pesanan</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <div class="your-order mb-50">
                <h3>Biodata Pemesan</h3>
                <div class="your-order-table table-responsive">
                    <table>
                        <tbody>
                            <tr class="cart_item">
                                <td style="width:20%">Nama : </td>
                                <td>{{$transaction->name}}</td>
                            </tr>
                            <tr class="cart_item">
                                <td style="width:20%">No. Hp : </td>
                                <td>{{$transaction->phone}}</td>
                            </tr>
                            <tr class="cart_item">
                                <td style="width:20%">Alamat : </td>
                                <td>{{$transaction->alamat}}</td>
                            </tr>
                            <tr class="cart_item">
                                <td style="width:20%">Kota : </td>
                                <td>{{$transaction->city->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="mt-3">
                        <a class="text-primary" title="Quick View" data-toggle="modal" href="#tambah-{{$transaction->id_transaksi}}">
                            kirim ke alamat lain ?
                        </a>
                    </p>
                </div>
            </div>
            <a href="{{url('/cart')}}" class="submit btn-sm btn-hover btn-danger" onclick="return confirm('Apakah anda ingin membatalkan pesanan ? ')">
                Batalkan Pesanan ? </i></a>
        </div>
    </div>
</div>

<!-- Modal Form Alamat -->
<div class="modal fade" id="tambah-{{$transaction->id_transaksi}}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="pe-7s-close" aria-hidden="true"></span>
        </button>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bio Penerima</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('/checkout/form')}}/{{$transaction->id_transaksi}}" method="post">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="">Nama Penerima</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="price">
                        <label for="">No Hp</label>
                        <input type="number" class="form-control" name="phone">
                    </div>
                    <div class="quick-view-select">
                        <div class="select-option-part">
                            <label>Provinsi</label>
                            <select class="select" name="province">
                                <option value="{{old('province')}}">- Please Select -</option>
                                @foreach($province as $prov => $value)
                                <option value="{{$prov}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="select-option-part">
                            <label>Kota</label>
                            <select class="select" name="city">
                                <option value="{{old('city')}}">- Please Select -</option>
                            </select>
                        </div>
                    </div>
                    <div class="price">
                        <label for="">Alamat</label>
                        <textarea class="form-control" name="alamat"></textarea>
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
@endsection

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@include('sweet::alert')
<script>
    $(document).ready(function() {
        $('select[name="province"]').on('change', function() {
            let provinceId = $(this).val();
            if (provinceId) {
                jQuery.ajax({
                    url: '/province/' + provinceId + '/cities',
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
        //ajax check ongkir
        $('select[name="courier"]').change(function(e) {
            e.preventDefault();

            let token = $("meta[name='csrf-token']").attr("content");
            let origin = $('input[name="origin"]').val();
            let destination = $('input[name="destination"]').val();
            let courier = $('select[name=courier]').val();
            let weight = $('input[name="weight"]').val();

            if (courier) {

                jQuery.ajax({
                    url: "/origin=" + origin + "&destination=" + destination + "&weight=" + weight + "&courier=" + courier,
                    dataType: "JSON",
                    type: "GET",
                    success: function(data) {
                        // console.log(data)
                        $('select[name="ongkir"]').empty();
                        $('select[name="ongkir"]').removeAttr('hidden')
                        $.each(data, function(key, value) {
                            $.each(value.costs, function(key1, value1) {
                                $.each(value1.cost, function(key2, value2) {
                                    $('select[name="ongkir"]').append('<option value="' + key + '">' + value1.service + 'Rp.' + value2.value + ' (' + value2.etd + ') hari' + '< /option>');
                                });
                            })
                        });
                    },
                });
            } else {
                $('select[name="ongkir"]').empty();
            }
        });
    });
</script>
@endsection