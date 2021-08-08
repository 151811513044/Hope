@component('mail::message')
# Thankyou For your Order !

## Invoice ID {{$transaction->uuid}} ({{date('d F Y', strtotime($transaction->tanggal))}})

### Pembayaran Berhasil Dilakukan
Pemesanan akan segera dikirim ke alamat anda.

## Billing Details:
<strong>{{ $transaction->name }}</strong>
<br> {{ $transaction->alamat }}, {{$transaction->city->name}}
<br> Email: {{ $transaction->customer->email }}
<br> Phone: {{ $transaction->phone }}


Thanks,<br>
{{ config('app.name') }}
@endcomponent