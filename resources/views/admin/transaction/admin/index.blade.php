@extends('admin.layout.master')
@section('page-title','Transaction')
@section('page')
<li><a href="{{url('/dashboard')}}">Dashboard</a></li>
<li class="active">Table Transaction</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Transaction</strong>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Nama Pemesan</th>
                                <th>Alamat</th>
                                <th>Total Transaksi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction as $trans)
                            <tr>
                                <td>{{ $trans->uuid }}</td>
                                <td>{{ $trans->name}}</td>
                                <td>{{ $trans->alamat }}, {{$trans->city->name}}</td>
                                <td>Rp. {{ number_format($trans->total_transaksi) }}</td>
                                <td>{{date('d F Y', strtotime($trans->tanggal))}}</td>
                                <td>
                                    @if($trans->status == 'SUCCESS')
                                    <span class="badge badge-success">Success</span>
                                    @elseif($trans->status == 'PENDING')
                                    <span class="badge badge-info">Pending</span>
                                    @elseif($trans->status == 'FAILED')
                                    <span class="badge badge-danger">Failed</span>
                                    @else
                                    <span></span>
                                    @endif
                                </td>

                                <td>
                                    @if($trans->status == 'PENDING')
                                    <!-- <form action="{{ route('transaction-status', $trans->id_transaksi)}}?status=SUCCESS" method="post" class="d-inline">
                                        @csrf
                                        <button class="btn btn-success btn-sm">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('transaction-status', $trans->id_transaksi)}}?status=FAILED" method="post" class="d-inline">
                                        @csrf
                                        <button class="btn btn-warning btn-sm">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form> -->
                                    @endif
                                    <a href="{{url('/pembayaran')}}/{{$trans->id_transaksi}}" class="btn btn-secondary btn-sm"><i class="fa fa-money"></i></a>
                                    <a href="#detail-{{ $trans->id_transaksi }}" class="btn btn-info btn-sm" data-remote="{{ route('transaction-show', $trans->id_transaksi)}}" data-target="#detail-{{$trans->id_transaksi}}" data-title="Detail Transaksi {{$trans->uuid}}" data-toggle="modal">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <!-- <form action="" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="
                                        return confirm('Apakah anda yakin ingin menghapus file ini ?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><!-- .animated -->
@endsection
<!-- Modal Detail -->
@foreach($transaction as $trans)
<div class="modal fade show" id="detail-{{ $trans->id_transaksi }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detail Transaksi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
            </div>>
            <div class="modal-body">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- End Modal Detail -->
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
</script>

<script>
    jQuery(document).ready(function() {
        $('#modal-${id}}}').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var modal = $(this);

            modal.find('.modal-body').load(button.data("remote"));
        });
    });
</script>
@endsection