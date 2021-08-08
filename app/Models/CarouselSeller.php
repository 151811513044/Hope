<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarouselSeller extends Model
{
    use HasFactory;
    protected $table = 'carousel_sellers';
    public $timestamps = true;

    protected $casts = [
        'product_id' => 'int'
    ];

    protected $fillable = [
        'photo', 'is_default', 'store_id'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_default', 1);
    }
}
