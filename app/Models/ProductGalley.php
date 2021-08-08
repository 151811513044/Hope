<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGalley extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'product_galleries';
    protected $primaryKey = 'id_gallery';
    public $timestamps = true;

    protected $casts = [
        'product_id' => 'int'
    ];

    public const UPLOAD_DIR = 'uploads';
    protected $guarded = [
        'id_category', 'created_at', 'update_at'
    ];

    public const SMALL = '135x141';
    public const MEDIUM = '312x400';
    public const LARGE = '600x656';
    public const EXTRA_LARGE = '1125x1200';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    public function scopeActive($query)
    {
        return $query->where('is_default', 1);
    }

    // public function getPhotoAttribute($value)
    // {
    //     return url('storage/' . $value);
    // }

}
