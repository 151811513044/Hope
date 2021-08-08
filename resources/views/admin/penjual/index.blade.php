@extends('admin.layout.master')
@section('page-title','Store')
@section('page')
<li><a href="{{url('/dashboard')}}">Dashboard</a></li>
<li class="active">Table Store</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Store</strong>
                </div>
                @if(session('status'))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr align="center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nama Toko</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($store as $str)
                            <tr align="center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$str->customer->name}}</td>
                                <td>{{$str->name}}</td>
                                <td>{{$str->alamat}}</td>
                                <td>{{$str->phone}}</td>
                                <td>{{$str->email}}</td>
                                <td style="width:10%">
                                    <form action="{{route('delete-store',$str->id)}}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="
                                        return confirm('Apakah anda yakin ingin menghapus file ini ?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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

@section('script')
<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/jszip.min.js"></script>
<script src="assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="assets/js/init/datatables-init.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
</script>
@endsection