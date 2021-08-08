@extends('admin.layout.master')
@section('page-title','Gallery Product')
@section('page')
<li><a href="{{url('/dashboard')}}">Dashboard</a></li>
<li><a href="{{url('/product')}}">Produk</a></li>
<li class="active">Galeri Produk</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Gallery {{$produk->nama_product}}</strong>
                    <a href="#tambah" data-toggle="modal">
                        <button class="btn btn-sm btn-outline-primary" style="float:right"><i class="fa fa-plus"></i></button>
                    </a>
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
                                <th>Nama Poduk</th>
                                <th>Photo</th>
                                <th>Is Default</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gallery as $gal)
                            <tr align="center">
                                <td style="width:10%">{{ $loop->iteration }}</td>
                                <td>{{$gal->product->nama_product}}</td>
                                <td>
                                    <img src="{{ asset('storage/images/product/'.$gal->photo) }}" height="80px" alt="">
                                </td>
                                <td>{{ $gal->is_default ? 'Ya' : 'Tidak'}}</td>
                                <td style="width:10%">
                                    <a href="#edit-{{$gal->id_gallery}}" data-toggle="modal">
                                        <button class="btn btn-sm btn-outline-primary"><i class="fa fa-pencil"></i></button>
                                    </a>
                                    <form action="{{ route('delete-gallery', $gal->id_gallery) }}" method="post" class="d-inline">
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
@foreach($gallery as $gal)
<div class="modal fade show" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Tambah Galeri Produk {{$gal->product->nama_product}}</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ url('/gallery')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}
                    <button type=" button" class="btn btn-primary btn-sm" style="float:right" id="upload"><span style="color:#fff"><i class="fa fa-plus"></i></span></button>
                    <br></br>
                    <input type="hidden" name="product_id" value="{{ $gal->product->id_product }}">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Product</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{{ $gal->product->nama_product }}" readonly>
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
                    <div class=" form-group row">
                        <input type="hidden" value="1" id="no">
                        <label class="col-sm-4 col-form-label" id="label-upload">Upload Foto</label>
                        <div class="col-sm-8">
                            <input type="file" name="photo[]" class="" accept="image/*" required><br>
                            <small>format: .jpg, .jpeg, .png</small>
                        </div>
                    </div>
                    <div class="file"></div>
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
<!-- End Modal Tambah -->
<!-- Modal Update -->
@foreach($gallery as $gal)
<div class="modal fade show" id="edit-{{$gal->id_gallery}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Edit Galeri Produk</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-gallery', $gal->id_gallery)}}" method="post">
                    {{ csrf_field()}}
                    @method('patch')
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Product</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" value="{{ $gal->product->nama_product }}" readonly>
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

<script>
    $(document).ready(function() {
        $('#upload').on('click', function() {
            let no = document.getElementById('no').value;
            document.getElementById('label-upload').innerHTML = "Upload Foto 1";
            no++;

            let el = '<div class="form-group row">' +
                '<label class="col-sm-4">Upload Foto ' + no + '</label>' +
                '<div class="col-sm-8">' +
                '<input type="file" name="photo[]" accept="image/*" required><br>' +
                '<small>format: .jpg, .jpeg, .png</small>' +
                '</div>' +
                '</div>';

            $('.file').append(el);
            document.getElementById('no').value = no;
        });
    });
</script>
@endsection