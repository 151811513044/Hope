<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CarouselSeller;
use App\Models\Category;
use App\Models\Payment;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductGalley;
use App\Models\Review;
use App\Models\Store;
use UxWeb\SweetAlert\SweetAlert;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);

        $this->data['q'] = null;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $seller = Store::where('cust_id', Auth::user()->id)->first();
        $category = Category::orderBy('name', 'asc')->get();
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        $carousels = Carousel::active()->orderBy('id', 'asc')->get();
        $products = Product::with(['galleries', 'store'])->inRandomOrder()->limit(8)->get();
        // Product Populer
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

        return view('home', compact('seller', 'category', 'products', 'q', 'carousels', 'populer', 'arrival'));
    }

    public function indexProduct(Request $request)
    {
        $category = Category::orderBy('name', 'asc')->get();
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        $products = Product::inRandomOrder()->paginate(10);

        $q = $request->q;
        if ($q) {
            $q = Str::replace('-', ' ', Str::slug($q));

            $products = Product::with('category')->where('nama_product', 'LIKE', "%{$q}%")->paginate(10);
            // $products = Product::whereRaw('MATCH(nama_product, slug) AGAINST (? IN NATURAL LANGUAGE MODE)', [$q]);
            // $products = $products->paginate(10);
        }

        if ($categorySlug = $request->category) {
            $products = Product::where('category_id', $categorySlug)->paginate(10);
        }

        return view('layouts.products.index', compact('products', 'seller', 'category', 'q'));
    }

    public function show(Request $request, $slug, $id)
    {
        $q = $request->q;
        $products = Product::with('galleries')->where('id_product', $id)->first();
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        $product = Product::with('galleries')->where('category_id', $products->category_id)->get();

        $reviews = Review::with('customer')->where('product_id', $products->id_product)->orderBy('id_review', 'desc')->simplePaginate(6);
        $notif = Review::where('product_id', $products->id_product)->count();
        // $gallery = ProductGalley::where('id_gallery', $id)->get();
        // dd($gallery);
        return view('layouts.products.show', compact('products', 'seller', 'q', 'product', 'reviews', 'notif'));
    }

    public function addReview(Request $request, $id)
    {
        $transaction_detail = TransactionDetail::findOrFail($id);
        // update telah di review
        $transaction_detail->update([
            'is_review' => 1
        ]);

        // Add Review
        $reviews = Review::create([
            'product_id' => $transaction_detail->product_id,
            'cust_id' => Auth::user()->cust_id,
            'comment' => $request->comment,
            'photo' => null
        ]);
        if ($request->has('photo')) {
            $file = $request->file('photo');
            $name = time() . '_' . $file->getClientOriginalName();

            // Image::make($file)->resize(1054, 236)->save('public/images/carousel/' . $name);
            $filePath = $file->storeAs('images/review', $name, 'public');

            $reviews->update([
                'photo' => $name
            ]);
        }
        alert()->success('Review added on This Product', 'Review Success');
        return back();
    }

    public function store(Request $request, $id)
    {
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        $q = $request->q;
        $carousels = CarouselSeller::active()->where('store_id', $seller->id)->orderBy('id', 'asc')->get();
        $store = Store::where('id', $id)->first();
        $prod = Product::where('store_id', $id)->first();
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
        return view('layouts.store.index', compact('q', 'products', 'category', 'prod', 'store', 'cari', 'seller', 'carousels'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $q = $request->q;
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        $user = User::findOrFail($id);
        $transaction = Transaction::with('payments')->where('cust_id', $user->cust_id)->orderBy('id_transaksi', 'desc')->first();
        // jika sudah bayar
        if ($transaction->is_cart == 2) {
            $cek_payment = Payment::where('transaction_id', $transaction->id_transaksi)->where('status', 0)->first();
            if ($transaction->status == "PENDING" && $cek_payment) {
                alert()->info('Please be Patient, Your Payment is On Process', 'Payment Processed');
                return redirect('/home');
            }
            $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id_transaksi)->get();
            $subtotal = 0;
            foreach ($transaction_detail as $td) {
                $subtotal += $td->total_harga;
            }
            $tax = 0.1 * $subtotal;
        } else {
            $transaction_detail = "";
            $subtotal = 0;
            $tax = 0;
        }

        return view('layouts.konfirmasi_pembayaran', compact('q', 'seller', 'transaction', 'transaction_detail', 'subtotal', 'tax'));
    }

    public function uploadPemb(Request $request, $id)
    {
        $request->validate([
            'upload' => 'required|max:4096',
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($request->has('upload')) {
            $file = $request->file('upload');
            $name = time() . '_' . $file->getClientOriginalName();

            // Image::make($file)->resize(1054, 236)->save('public/images/carousel/' . $name);
            $filePath = $file->storeAs('images/bukti_pembayaran', $name, 'public');

            $payment = new Payment([
                'transaction_id' => $transaction->id_transaksi,
                'bukti_pembayaran' => $name,
                'status' => 0
            ]);
            $payment->save();
        }

        alert()->success('Thank You For Your Payment', 'Payment Success');
        return redirect('/home');
    }

    public function history(Request $request)
    {
        $q = $request->q;
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        // Transaksi sukses dari user yg sedang login
        $transaction = Transaction::where('cust_id', Auth::user()->cust_id)->get();
        if (!empty($transaction)) {
            foreach ($transaction as $trans) {
                if ($trans->status == "SUCCESS") {
                    $transaction_detail = TransactionDetail::where('transaction_id', $trans->id_transaksi)->get();
                } else {
                    alert()->info('You dont have a Successfull Order ', 'Make an Order First');
                    return redirect('/home');
                }
            }
        }

        return view('layouts.history', compact('q', 'seller', 'transaction_detail'));
    }
}
