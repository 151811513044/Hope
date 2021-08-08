@extends('admin.layout.master')
@section('page-title','Carousel Admin')
@section('page')
<li><a href="{{url('/dashboard/seller')}}">Dashboard</a></li>
<li class="active">Carousel</li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Carousel</strong>
                    @if($store->products->first())
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
                <div class="alert alert-danger">
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
                                <th>Photo</th>
                                <th>Is Default</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carousels as $carousel)
                            <tr align="center">
                                <td style="width:10%">{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/images/carousel/seller/'.$carousel->photo) }}" height="80px" alt="">
                                </td>
                                <td>{{ $carousel->is_default ? 'Ya' : 'Tidak'}}</td>
                                <td style="width:10%">
                                    <a href="#edit-{{$carousel->id}}" data-toggle="modal">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></button>
                                    </a>
                                    <form action="{{ route('delete-gallery', $carousel->id) }}" method="post" class="d-inline">
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
<!-- Modal Tambah -->
<div class="modal fade show" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Tambah Carousel</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ url('/carousel')}}/{{Auth::user()->id}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label" id="label-upload">Upload Foto</label>
                        <div class="col-sm-8">
                            <input type="file" name="photo" class="" accept="image/*" required><br>
                            <small>size image: 1170 x 500 (recommended)</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Is Default</label>
                        <div class="col-sm-8">
                            <div class="form-check-inline form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="is_default" value="1" class="form-check-input">Ya
                                </label>
                                &nbsp;
                                <label class="form-check-label">
                                    <input type="radio" name="is_default" value="0" class="form-check-input">Tidak
                                </label>
                            </div>
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
</div>
<!-- End Modal Tambah -->
<!-- Modal Update -->
@foreach($carousels as $carousel)
<div class="modal fade show" id="edit-{{$carousel->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Edit Galeri Produk</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ url('/carousel/seller')}}/{{ $carousel->id}}" method="post">
                    {{ csrf_field()}}
                    @method('patch')
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Is Default</label>
                        <div class="col-sm-8">
                            <div class="form-check-inline form-check">
                                <label class="form-check-label">
                                    <input type="radio" name="is_default" value="1" class="form-check-input">Ya
                                </label>
                                &nbsp;
                                <label class="form-check-label">
                                    <input type="radio" name="is_default" value="0" class="form-check-input">Tidak
                                </label>
                            </div>
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
</div>
@endforeach
<!-- End Modal Update -->
@section('script')
<script src="{{ asset('assets/js/lib/data-table/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/jszip.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/data-table/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/init/datatables-init.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#bootstrap-data-table-export').DataTable();
    });
</script>
@endsection