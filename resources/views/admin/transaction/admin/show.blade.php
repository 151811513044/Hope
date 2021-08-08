<div class="content">
    <h3 class="mb-3">Detail Transaksi</h3>
    <table class="table table-bordered">
        <tr>
            <th>Invoice ID</th>
            <td>{{ $detail->uuid }}</td>
        </tr>
        <tr>
            <th>Tgl Transaksi</th>
            <td>{{ $detail->tanggal }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $detail->name }}</td>
        </tr>
        <tr>
            <th>No HP</th>
            <td>{{ $detail->phone }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $detail->alamat }}</td>
        </tr>
        <tr>
            <th>Total Transaksi</th>
            <td>{{ $detail->total_transaksi }}</td>
        </tr>
        <tr>
            <th>Transaksi Status</th>
            <td>{{ $detail->status }}</td>
        </tr>
        <tr>
            <th>Pembelian Produk</th>
            <td>
                <table class="table table-bordered w-100">
                    <tr>
                        <th>Nama</th>
                        <th>Qty</th>
                        <th>Harga</th>
                    </tr>
                    @foreach($detail->details as $item)
                    <tr>
                        <td>{{ $item->product->nama_product }}</td>
                        <td style="width:5%;">{{ $item->quantity }}</td>
                        <td>Rp. {{ number_format($item->total_harga) }}</td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
    <!-- <div class="row">
        <div class="col-4">
            <form action="{{ route('transaction-status', $detail->id_transaksi)}}?status=SUCCESS" method="post">
                @csrf
                <button class="btn btn-success btn-block">
                    <i class="fa fa-check"></i> Set success
                </button>
            </form>
        </div>
        <div class="col-4">
            <form action="{{ route('transaction-status', $detail->id_transaksi)}}?status=PENDING" method="post">
                @csrf
                <button class="btn btn-info btn-block">
                    <i class="fa fa-spinner"></i> Set Pending
                </button>
            </form>
        </div>
        <div class="col-4">
            <form action="{{ route('transaction-status', $detail->id_transaksi)}}?status=FAILED" method="post">
                @csrf
                <button class="btn btn-warning btn-block">
                    <i class="fa fa-times"></i> Set Failed
                </button>
            </form>
        </div>
    </div> -->
</div>