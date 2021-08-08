<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_review';

    protected $fillable = [
        'product_id', 'comment', 'cust_id', 'photo'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }
}
