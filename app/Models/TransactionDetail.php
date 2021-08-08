<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'id_transaction_detail';

    protected $casts = [
        'transaction_id' => 'int',
        'product_id' => 'int'
    ];

    protected $fillable = [
        'transaction_id', 'product_id', 'quantity', 'total_harga', 'ongkir', 'kurir_id', 'is_review'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id_transaksi');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }
    public function courier()
    {
        return $this->belongsTo(Courier::class, 'kurir_id', 'id');
    }
}
