@extends('admin.layout.master')
@section('page-title','Laporan Pendapatan')
@section('page')
<li><a href="{{url('/dashboard/seller')}}">Dashboard</a></li>
<li class="active">Table Laporan Pendapatan</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Laporan Pendapatan</strong>
                    <p>Periode : {{date('d F Y', strtotime($startDate))}} - {{date('d F Y', strtotime($endDate))}}</p>
                    <div class="row my-3">
                        <div class="col-md-12 d-inline-block">
                            <form action="{{url('/report')}}" method="get">
                                <p class="d-inline">From </p>
                                <input type="date" class="form-control col-2 d-inline mr-2" name="tglawal">
                                <p class="d-inline ml-2">To </p>
                                <input type="date" class="form-control col-2 d-inline-block mr-2" name="tglakhir">
                                <select name="export" id="" class="form-control mx-2 col-2 d-inline-block">
                                    <option value="" selected>- Export To -</option>
                                    <option value="xlsx">Excel</option>
                                    <option value="pdf">Pdf</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-hover mx-2 d-inline-block">Go</button>
                            </form>
                            @if (session('error'))
                            <div class="text-danger">{{ session('error') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Order</th>
                                <th>Product Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenues as $revenue)
                            <tr>
                                <td>{{date('d F Y', strtotime($revenue->tanggal))}}</td>
                                <td>{{$revenue->transaksi}}</td>
                                <td>{{$revenue->qty}}</td>
                                <td>{{$revenue->harga}}</td>
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
@endsection