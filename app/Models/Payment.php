<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_payment';

    protected $fillable = [
        'transaction_id', 'bukti_pembayaran', 'status'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id_transaksi');
    }
}
