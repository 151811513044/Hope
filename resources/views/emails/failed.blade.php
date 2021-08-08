@component('mail::message')
# Thankyou For your Order !

## Invoice ID {{$transaction->uuid}} ({{date('d F Y', strtotime($transaction->tanggal))}})

## Billing Details:
<strong>{{ $transaction->name }}</strong>
<br> {{ $transaction->alamat }}, {{$transaction->city->name}}
<br> Email: {{ $transaction->customer->email }}
<br> Phone: {{ $transaction->phone }}

Mohon maaf transaksi anda telah di batalkan, karena alasan sebagai berikut :<br>
<strong>{{$transaction->alasan}}</strong>. Silahkan lakukan pemesanan lagi.

@component('mail::button', ['url' => 'http://127.0.0.1:8000'])
Belanja Lagi
@endcomponent


Thanks,<br>
### Hope Marketplace
@endcomponent