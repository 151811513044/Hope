@extends('admin.layout.master')
@section('page-title','Transaction')
@section('page')
<li><a href="{{url('/dashboard')}}">Dashboard</a></li>
<li><a href="{{url('/transaction')}}">Transaction</a></li>
<li class="active">Table Validation Payment</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Transaction</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Bukti Pembayaran</th>
                                <th>Status</th>
                                @if($transaction->status == "PENDING")
                                <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                            <tr>
                                <td>{{$payment->transaction->uuid}}</td>
                                <td>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><img src="{{ asset('storage/images/bukti_pembayaran/'.$payment->bukti_pembayaran) }}" style="height:100px;object-fit:contain;" alt="Error (Hope)"></li>
                                        <li class="list-group-item">
                                            <a href="#preview-{{$payment->id_payment}}" class="badge badge-primary" data-toggle="modal">Preview</a>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    @if($payment->status == 0)
                                    <span class="badge badge-warning">InValid</span>
                                    @elseif($payment->status == 1)
                                    <span class="badge badge-success">Valid</span>
                                    @endif
                                </td>
                                @if($payment->transaction->status == "PENDING")
                                <td>
                                    <form action="{{ url('/pembayaran/')}}/{{$payment->id_payment}}" method="post" class="d-inline">
                                        @csrf
                                        @method('patch')
                                        <button class="btn btn-success btn-sm" onclick="return confirm('Apakah anda yakin pembayaran sesuai ?')">
                                            <i class="fa fa-check"></i> set-valid
                                        </button>
                                    </form>
                                    <a href="#failed-{{$payment->id_payment}}" data-toggle="modal">
                                        <button class="btn btn-danger">
                                            <i class="fa fa-close"> set-failed</i>
                                        </button>
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order Detail</h4>
                    <hr>
                    <table class="table table-hover table-borderless">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction_detail as $td)
                            <tr>
                                <td>{{$td->product->nama_product}}</td>
                                <td align="center">{{$td->quantity}}</td>
                                <td>Rp. {{number_format($td->total_harga)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td align="right">Subtotal :</td>
                                <td>Rp. {{number_format($subtotal)}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td align="right">Tax 10% :</td>
                                <td>Rp. {{number_format($tax)}}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td align="right">Ongkir :</td>
                                <td> - </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td align="right">Total Transaksi :</td>
                                <td>Rp. {{number_format($td->transaction->total_transaksi)}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- .animated -->
@endsection
<!-- Modal Preview -->
@foreach($payments as $payment)
<div class="modal fade show" id="preview-{{$payment->id_payment}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title">Preview Bukti Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
            </div>
            <div class="modal-body" style="height:600px;">
                <embed src="{{url('/preview/'.$payment->id_payment)}}" style="height:100%" width="100%" heigth="100%"></embed>
            </div>

            <!-- <div class="modal-footer modal-footer-upload">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button> 
                    <button type="submit" class="btn btn-primary"  id="modalDelete">Simpan</a>
                </div> -->
        </div>
    </div>
</div>
@endforeach
<!-- End Modal Preview -->
<!-- Modal Failed -->
@foreach($payments as $payment)
<div class="modal small fade" id="failed-{{$payment->id_payment}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{url('/pembayaran/failed/')}}/{{$payment->id_payment}}" method="post">
                @csrf
                @method('patch')
                <div class="modal-header bg-danger">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Transaction Failed</h4>
                </div>
                <div class="modal-body modal-body-upload">
                    <div class="form-group col-12">
                        <textarea name="alasan" rows="10" colspan="30" class="form-control" placeholder="Isikan Alasan" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- End Modal Failed -->

@section('script')
<script src="{{asset('assets/js/lib/data-table/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/jszip.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/js/lib/data-table/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/init/datatables-init.js')}}"></script>
@endsection