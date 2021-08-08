<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaction</title>
    <style type="text/css">
        table {
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10pt;
            text-align: left;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table th,
        td {
            border-bottom: 1px solid #ddd;
        }

        table th {
            border-top: 1px solid #ddd;
            height: 40px;
        }

        table td {
            height: 25px;
        }

        table tr td .col {
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaction</h2>
    <hr>
    <p>Period : {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</p>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Invoice ID</th>
                <th>Nama Pemesan</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaction_detail as $td)
            <tr>
                <td>{{date('d F Y', strtotime($td->tanggal))}}</td>
                <td>{{$td->uuid}}</td>
                <td>{{$td->name}}</td>
                <td>{{ $td->nama_product}}</td>
                <td>{{ $td->quantity}}</td>
                <td>Rp. {{ number_format($td->total_harga) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No records found</td>
            </tr>
            @endforelse
            @forelse($total_harga as $th)
            <tr>
                <td colspan="5" class="col">Total</td>
                <td>Rp. {{ number_format($th->harga) }}</td>
            </tr>
            @empty
            <tr></tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>