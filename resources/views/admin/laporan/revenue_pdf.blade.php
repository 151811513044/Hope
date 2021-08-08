<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>
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
    <h2>Laporan Pendapatan</h2>
    <hr>
    <p>Period : {{ date('d F Y', strtotime($startDate)) }} - {{ date('d F Y', strtotime($endDate)) }}</p>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Order</th>
                <th>Product Sold</th>
                <th>Revenue</th>
            </tr>
        </thead>
        <tbody>
            @forelse($revenues as $revenue)
            <tr>
                <td>{{date('d F Y', strtotime($revenue->tanggal))}}</td>
                <td>{{$revenue->transaksi}}</td>
                <td>{{$revenue->qty}}</td>
                <td>{{$revenue->harga}}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>