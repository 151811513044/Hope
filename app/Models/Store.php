<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id', 'name', 'email', 'phone', 'alamat', 'cust_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id_city');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function carousels()
    {
        return $this->hasMany(CarouselSeller::class, 'store_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }
}
