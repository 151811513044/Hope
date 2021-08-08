<?php

namespace App\Mail;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifPembayaran extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        return $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->detail = TransactionDetail::where('transaction_id', $this->transaction->id_transaksi)->get();
        $subtotal = 0;
        foreach ($this->detail as $td) {
            $subtotal += $td->total_harga;
        }
        $tax = 0.1 * $subtotal;

        $email =  $this->markdown('emails.pembayaran')
            ->with([
                'tax' => $tax,
                'subtotal' => $subtotal
            ]);

        return $email;
    }
}
