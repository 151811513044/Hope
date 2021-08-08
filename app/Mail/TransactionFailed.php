<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransactionFailed extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;
    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, $payment)
    {
        $this->transaction = $transaction;
        $this->payment = $payment->bukti_pembayaran;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $path = public_path() . '/storage/images/bukti_pembayaran/' . $this->payment;
        // dd($path);
        return $this->markdown('emails.failed')->attach($path);
    }
}
