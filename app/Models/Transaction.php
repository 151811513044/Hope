<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'cust_id', 'uuid', 'name', 'phone', 'alamat', 'city_id', 'email', 'tanggal', 'total_transaksi', 'status', 'is_cart', 'alasan'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id_city');
    }
    public function payments()
    {
        return $this->hasOne(Payment::class, 'transaction_id');
    }
}
