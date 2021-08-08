<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;
    protected $table = 'carousels';
    public $timestamps = true;

    protected $casts = [
        'product_id' => 'int'
    ];

    protected $fillable = [
        'photo', 'is_default'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_default', 1);
    }
}
