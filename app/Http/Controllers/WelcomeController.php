<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CarouselSeller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WelcomeController extends Controller
{
    public function welcome(Request $request)
    {
        $category = Category::orderBy('name', 'asc')->get();
        $carousels = Carousel::active()->orderBy('id', 'asc')->get();
        $products = Product::with(['galleries', 'store'])->inRandomOrder()->limit(8)->get();

        $month = now()->format('m');
        $populer = Product::select('products.*', DB::raw('count(td.id_transaction_detail) as count'))
            ->join('transaction_details as td', 'products.id_product', 'td.product_id')
            ->join('transactions as trans', 'trans.id_transaksi', 'td.transaction_id')
            ->where(DB::raw('Month(trans.tanggal)'), $month)->where('trans.status', 'SUCCESS')->where('td.deleted_at', null)
            ->where('products.stock_product', '!=', 0)
            ->groupBy('products.id_product')
            ->orderBy('count', 'desc')
            ->paginate(10);
        // New Arrival
        $arrival = Product::with(['galleries', 'store'])->orderBy('created_at', 'desc')->limit(5)->get();
        $q = $request->q;
        // dd($product);
        return view('welcome', compact('category', 'products', 'q', 'carousels', 'populer', 'arrival'));
    }

    public function product(Request $request)
    {
        $category = Category::orderBy('name', 'asc')->get();
        $products = Product::inRandomOrder()->paginate(20);
        $q = $request->q;
        if ($q) {
            $q = Str::replace('-', ' ', Str::slug($q));

            $products = Product::with('category')->where('nama_product', 'LIKE', "%{$q}%")->paginate(10);
        }
        if ($categorySlug = $request->category) {
            $products = Product::where('category_id', $categorySlug)->paginate(10);
        }

        return view('well-product', compact('category', 'products', 'q'));
    }

    public function store(Request $request, $id)
    {
        $q = $request->q;
        $store = Store::where('id', $id)->first();
        // Nampilkan 
        $prod = Product::where('store_id', $id)->first();
        $carousels = CarouselSeller::active()->where('store_id', $id)->orderBy('id', 'asc')->get();
        $products = Product::with(['category', 'store'])->where('store_id', $id)->paginate(10);
        $category = Category::orderBy('name', 'asc')->get();
        $cari = $request->cari;
        if ($cari) {
            $products = Product::where('store_id', $id)
                ->where('nama_product', 'LIKE', "%{$cari}%")->paginate(10);
        }
        if ($categorySlug = $request->category) {
            $products = Product::where('store_id', $id)->where('category_id', $categorySlug)->paginate(10);
        }
        // dd($prod);
        return view('well-store', compact('q', 'products', 'category', 'prod', 'store', 'cari', 'carousels'));
    }

    public function detailProduct(Request $request, $slug, $id)
    {
        $q = $request->q;
        $products = Product::where('id_product', $id)->first();
        $product = Product::with('galleries')->where('category_id', $products->category_id)->get();

        $reviews = Review::with('customer')->where('product_id', $products->id_product)->orderBy('id_review', 'desc')->simplePaginate(6);
        $notif = Review::where('product_id', $products->id_product)->count();
        // dd($reviews);
        // $gallery = ProductGalley::where('id_gallery', $id)->get();
        return view('well-detail', compact('products', 'q', 'product', 'reviews', 'notif'));
    }
}
