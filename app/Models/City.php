<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'city_id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'city_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'city_id');
    }
}
