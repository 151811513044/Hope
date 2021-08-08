<?php

namespace App\Mail;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction_detail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction_detail)
    {
        return $this->transaction_detail = $transaction_detail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subtotal = 0;
        foreach ($this->transaction_detail as $td) {
            $transaction = Transaction::where('id_transaksi', $td->transaction_id)->first();
            $subtotal += $td->total_harga;
        }
        return $this->markdown('emails.orderlist')
            ->with([
                'uuid' => $transaction->uuid,
                'nama' => $transaction->name,
                'alamat' => $transaction->alamat,
                'city' => $transaction->city->name,
                'phone' => $transaction->phone,
                'tanggal' => $transaction->tanggal,
                'subtotal' => $subtotal
            ])
            ->subject('List Pemesanan');
    }
}
