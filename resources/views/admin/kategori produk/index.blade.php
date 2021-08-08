@extends('admin.layout.master')
@section('page-title','Kategori Product')
@section('page')
@if(Auth::user()->role == 'admin')
<li><a href="{{url('/dashboard')}}">Dashboard</a></li>
@endif
@if(Auth::user()->role == 'mix')
<li><a href="{{url('/dashboard/seller')}}">Dashboard</a></li>
@endif
<li class="active">Kategori Produk</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Category Product</strong>
                    @if(auth()->user()->role == 'admin')
                    <a href="#tambah" data-toggle="modal">
                        <button class="btn btn-sm btn-outline-primary" style="float:right"><i class="fa fa-plus"></i></button>
                    </a>
                    @endif
                </div>
                @if(session('status'))
                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (count($errors) > 0)
                <div class="m-2 alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="card-body">
                    <table id="bootstrap-data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr align="center">
                                <th>Nomor</th>
                                <th>Nama Kategori</th>
                                @if(auth()->user()->role == 'admin')
                                <th>Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category as $cat)
                            <tr align="center">
                                <td style="width:10%">{{ $loop->iteration }}</td>
                                <td>{{$cat->name}}</td>
                                @if(auth()->user()->role == 'admin')
                                <td style="width:20%">
                                    <button class="btn btn-success btn-sm status" type="button" id="">Active</button>
                                    <button class="btn btn-secondary btn-sm status" type="button" id="">Disable</button>
                                </td>
                                @endif
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
<div class="modal fade show" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Tambah Kategori Produk</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ url('/category')}}" method="post">
                    {{ csrf_field()}}
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Kategori</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</a>
                    </form>
            </div>
        </div>
    </div>
</div>
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