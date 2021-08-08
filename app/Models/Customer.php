<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id', 'name', 'email', 'phone', 'alamat'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id_city');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'cust_id');
    }

    public function stores()
    {
        return $this->hasOne(Store::class, 'cust_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'cust_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'cust_id');
    }
}
