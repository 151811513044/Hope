@extends('admin.layout.master')
@section('page-title','Produk')
@section('page')
@if(Auth::user()->role == 'admin')
<li><a href="{{url('/dashboard')}}">Dashboard</a></li>
@endif
@if(Auth::user()->role == 'mix')
<li><a href="{{url('/dashboard/seller')}}">Dashboard</a></li>
@endif
<li class="active">Table Produk</a></li>
@endsection
@section('content')
<div class="animated fadeIn">
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">Data Table Product</strong>
                    @if(auth()->user()->role == 'mix')
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
                                <th>ID</th>
                                @if(Auth::user()->role == 'admin')
                                <th>Nama Toko</th>
                                @endif
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                @if(auth()->user()->role == 'mix')
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product as $prod)
                            <tr align="center">
                                <td>{{ $loop->iteration }}</td>
                                @if(Auth::user()->role == 'admin')
                                <td>{{ $prod->store->name}}</td>
                                @endif
                                <td>{{ $prod->nama_product }}</td>
                                <td>{{ $prod->category->name }}</td>
                                <td>{!! $prod->description !!}</td>
                                <td>
                                    Rp. {{number_format($prod->harga_product)}}
                                </td>
                                <td>{{ $prod->stock_product}}</td>
                                @if(auth()->user()->role == 'mix')
                                <td>
                                    <a href="{{ route('product-gallery', $prod->id_product)}}" class="btn btn-info btn-sm"><i class="fa fa-picture-o"></i></a>
                                    <a href="#edit-{{$prod->id_product}}" data-toggle="modal">
                                        <button class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></button>
                                    </a>
                                    <form action="{{route('delete-product',$prod->id_product)}}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm" onclick="
                                        return confirm('Apakah anda yakin ingin menghapus file ini ?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
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
<!-- Modal Tambah Produk -->
<div class="modal fade show" id="tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Tambah Produk</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ url('/product')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field()}}
                    <button type="button" class="btn btn-primary btn-sm" style="float:right" id="upload"><span style="color:#fff"><i class="fa fa-plus"></i></span></button>
                    <br></br>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" value="{{ old('name')}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Kategori</label>
                        <div class="col-sm-8">

                            <select name="category" id="selectLg" class="form-control form-control">
                                <option readonly>Pilih Kategori</option>
                                @foreach($kategori as $kat)
                                <option value="{{$kat->id_category}}">{{$kat->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Harga Produk</label>
                        <div class="col-sm-8">
                            <input type="number" name="harga_product" class="form-control" value="{{ old('harga_product')}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Stock</label>
                        <div class="col-sm-8">
                            <input type="number" name="stock_product" class="form-control" value="{{ old('stock_product')}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Berat</label>
                        <div class="col-sm-4">
                            <input type="number" name="berat" class="form-control" value="{{ old('berat')}}" required>
                        </div>
                        <div class="col-sm-4">
                            <label>per gram</label>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Deskripsi Singkat</label>
                        <div class="col-sm-8">
                            <textarea name="description" class="ckeditor form-control" value="{{ old('description')}}"></textarea>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Deskripsi</label>
                        <div class="col-sm-8">
                            <textarea name="long_desc" class="ckeditor2 form-control" value="{{ old('long_desc')}}"></textarea>
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
<!-- End Modal Tambah Produk -->
<!-- Modal Edit Produk -->
@foreach($product as $prod)
<div class="modal fade show" id="edit-{{$prod->id_product}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h class="modal-title" style="color:azure" id="myModalLabel">Edit Produk</h>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit-product', $prod->id_product)}}" method="post">
                    {{ csrf_field()}}
                    @method('patch')
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Nama Produk</label>
                        <div class="col-sm-8">
                            <input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $prod->nama_product}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Kategori</label>
                        <div class="col-sm-8">
                            <select name="category" class="form-control form-control">
                                <option value="{{$prod->category->id_category}}">{{$prod->category->name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Harga Produk</label>
                        <div class="col-sm-8">
                            <input type="number" name="harga_product" class="form-control" value="{{old('harga_product') ? old('harga_product') : $prod->harga_product}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Stock</label>
                        <div class="col-sm-8">
                            <input type="number" name="stock_product" class="form-control" value="{{ old('stock_product') ? old('stock_product') : $prod->stock_product}}" required>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label class="col-sm-4 col-form-label">Berat</label>
                        <div class="col-sm-4">
                            <input type="number" name="berat" class="form-control" value="{{ old('berat') ? old('berat') : $prod->berat }}" required>
                        </div>
                        <div class="col-sm-4">
                            <label>per gram</label>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="description" class="col-sm-4 col-form-label">Deskripsi Singkat</label>
                        <div class="col-sm-8">
                            <textarea name="description" class="ckeditor3 form-control">{!!$prod->description!!}</textarea>
                        </div>
                    </div>
                    <div class=" form-group row">
                        <label for="description" class="col-sm-4 col-form-label">Deskripsi Singkat</label>
                        <div class="col-sm-8">
                            <textarea rows="4" name="long_desc" class="ckeditor4 form-control">{!!$prod->long_description!!}</textarea>
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
<!-- End Modal Edit Produk -->
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
    ClassicEditor
        .create(document.querySelector('.ckeditor2'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('.ckeditor3'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('.ckeditor4'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
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