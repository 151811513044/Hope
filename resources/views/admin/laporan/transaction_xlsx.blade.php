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
        @foreach($transaction_detail as $td)
        <tr>
            <td>{{date('d F Y', strtotime($td->tanggal))}}</td>
            <td>{{$td->uuid}}</td>
            <td>{{$td->name}}</td>
            <td>{{ $td->nama_product}}</td>
            <td>{{ $td->quantity}}</td>
            <td>Rp. {{ number_format($td->total_harga) }}</td>
        </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td>Rp. {{ number_format($total) }}</td>
        </tr>
    </tbody>
</table>
</body>

</html>