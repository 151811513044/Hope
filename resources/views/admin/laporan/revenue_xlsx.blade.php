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
        @foreach($revenues as $revenue)
        <tr>
            <td>{{$revenue->tanggal}}</td>
            <td>{{$revenue->transaksi}}</td>
            <td>{{$revenue->qty}}</td>
            <td>{{$revenue->harga}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>

</html>