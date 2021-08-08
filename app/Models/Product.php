<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'id_product';

    protected $fillable = [
        'category_id', 'store_id', 'nama_product', 'slug', 'harga_product', 'stock_product', 'description', 'long_description', 'berat'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id_category');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGalley::class, 'product_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }
    public function scopePopular($query, $limit = 10)
    {
        $month = now()->format('m');

        return $query->select('products.*')->select(DB::raw('COUNT(td.id_transaction_detail) as total_sold'))
            ->join('transaction_details as td', 'td.product_id', '=', 'products.id_product')
            ->join('transactions as trans', 'td.transaction_id', '=', 'trans.id_transaksi')
            ->where('trans.status', 'success')->where(DB::raw('month(trans.tanggal)'), $month)
            ->groupBy('products.id_product')
            ->orderBy('total_sold', 'DESC')
            ->limit($limit);
    }
}
