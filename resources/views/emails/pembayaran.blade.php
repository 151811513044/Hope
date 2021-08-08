@component('mail::message')
# Thankyou For your Order !

## Invoice ID {{$transaction->uuid}} ({{date('d F Y', strtotime($transaction->tanggal))}})

## Billing Details:
<strong>{{ $transaction->name }}</strong>
<br> {{ $transaction->alamat }}, {{$transaction->city->name}}
<br> Email: {{ $transaction->customer->email }}
<br> Phone: {{ $transaction->phone }}

@component('mail::table')
| Product | Quantity | Price |
| ------------- |:-------------:| --------:|
@foreach ($transaction->details as $item)
| {{ $item->product->nama_product }} | {{ $item->quantity }} | {{ number_format($item->total_harga) }} |
@endforeach
| &nbsp; | <strong>Sub total</strong> | {{ number_format($subtotal) }} |
| &nbsp; | Tax (10%) | {{ number_format($tax) }} |
| &nbsp; | Ongkir | {{ number_format($tax) }} |
| &nbsp; | <strong>Total</strong> | <strong>{{ number_format($transaction->total_transaksi) }}</strong>|
@endcomponent

Pembayaran dapat dilakukan melalui bank transfer. <br>
Kirim ke nomor rekening di bawah : <br>
1. Bank BCA No. Rekening : <strong>6788 1572 42</strong> a/n : <strong>Hope Admin Rais</strong><br>
2. Bank Mandiri No. Rekening : <strong>070-00-0625548-3</strong> a/n : <strong>Hope Admin Cindy</strong><br>
1. Bank BRI No. Rekening : <strong>0504.01.023771.44.0</strong> a/n : <strong>Hope Admin Tono</strong><br>

Thanks You,<br>
### Hope Marketplace
@endcomponent