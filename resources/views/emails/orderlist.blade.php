@component('mail::message')
# Thankyou For your Order !

## {{$uuid}} ({{date('d F Y', strtotime($tanggal))}})

## Billing Details:
<strong>{{ $nama }}</strong>
<br> {{ $alamat }}, {{$city}}
<br> Phone: {{ $phone }}

@component('mail::table')
| Product | Ekspedisi | Toko |
| ------------- |:-------------:| --------:|
@foreach ($transaction_detail as $item)
| {{ $item->product->nama_product }}<br>Qty : {{ $item->quantity }} | JNE | {{$item->product->store->name}} |
@endforeach
| &nbsp; | <strong>Sub total</strong> | {{ number_format($subtotal) }} |
@endcomponent

Segera kirimkan barang pesanan yang sesuai dengan toko anda.<br>
Cek Dashboard anda untuk info pemesanan lebih lanjut.

Thanks,<br>
### Hope Marketplace
@endcomponent