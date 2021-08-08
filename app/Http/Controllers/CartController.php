<?php

namespace App\Http\Controllers;

use App\Mail\NotifPembayaran;
use App\Models\City;
use App\Models\Courier;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductGalley;
use App\Models\Province;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use UxWeb\SweetAlert\SweetAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Stringable;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();
        $products = Product::inRandomOrder()->paginate(8);
        // menampilkan transaksi yg trakir dilakukan oleh user yg login sekarang
        // ketika is_cart = 1 (checkout), bisa kembali. is_cart = 2 (sudah pesan tpi belom bayar), tdk bisa mengisi cart
        $transaction = Transaction::where('cust_id', Auth::user()->cust_id)->orderBy('id_transaksi', 'desc')->first();
        // dd($transaction);
        if ($transaction) {
            // jika sudah di halaman checkout tetapi kembali ke halaman cart
            if ($transaction->is_cart == 1) {
                $transaction->update([
                    'is_cart' => 0
                ]);
            }
            // Menampilkan cart dari user yg login sekarang
            $transaction = $transaction->where('is_cart', 0)->where('cust_id', Auth::user()->cust_id)->first();
            // transaction detail 
            if ($transaction) {
                $transaction_detail = TransactionDetail::with(['product', 'transaction'])
                    ->where('transaction_id', $transaction->id_transaksi)->get();

                $subtotal = 0;
                foreach ($transaction_detail as $item => $td) {
                    $subtotal += $td->total_harga;
                }
            } else {
                $transaction_detail = "Not Available Data In this Cart";
                $subtotal = 0;
            }
        }

        // dd($transaction);

        return view('layouts.cart.index', compact('q', 'seller', 'products', 'transaction_detail', 'transaction', 'subtotal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $product = Product::where('id_product', $id)->first();
        $uuid = 'TRS' . rand(100, 999) . Carbon::now()->format("dmY") . Auth::user()->cust_id;
        $cust = Customer::where('id', Auth::user()->cust_id)->first();
        $tgl = Carbon::now();

        // validasi stock
        if ($request->qty > $product->stock_product) {
            return back()->with('error', 'Jumlah Pesanan Melebihi Stock');
        }

        // Cek agar tidak bisa melakukan pemesanan 2x ketika pemesanan trakir masih belum sukses
        $transaction = Transaction::where('cust_id', Auth::user()->cust_id)->orderBy('id_transaksi', 'desc')->first();
        if ($transaction) {
            // Jika tahap pembayaran/is_cart = 2 dan status = pending, tidak bisa nambah produk
            if ($transaction->status == 'PENDING' && $transaction->is_cart == 2) {

                alert()->warning('Please Finish Your Payment Before Order Again', 'Warning Message');
                return back();
            } else {
                // validasi Transasction
                $cek_transaction = Transaction::where('cust_id', Auth::user()->cust_id)->where('is_cart', 0)->first();

                // Jika belum ada
                if (empty($cek_transaction)) {
                    // Simpan ke database Transaction
                    $transaction = Transaction::create([
                        'cust_id' => $cust->id,
                        'uuid' => $uuid,
                        'name' => $cust->name,
                        'phone' => $cust->phone,
                        'alamat' => $cust->alamat,
                        'city_id' => $cust->city_id,
                        'tanggal' => $tgl,
                        'status' => 'PENDING',
                        'is_cart' => 0,
                        'total_transaksi' => 0
                    ]);
                }
                $transaction_id = Transaction::where('cust_id', Auth::user()->cust_id)->where('is_cart', 0)->first();

                // cek transaction detail
                //Apakah transaction detail dengan id product dan id transaksi yg sama sudah di buat
                $cek_transaction_detail = TransactionDetail::where('product_id', $product->id_product)
                    ->where('transaction_id', $transaction_id->id_transaksi)->first();

                if (empty($cek_transaction_detail)) {
                    $transaction_detail = TransactionDetail::create([
                        'product_id' => $product->id_product,
                        'transaction_id' => $transaction_id->id_transaksi,
                        'quantity' => $request->qty,
                        'total_harga' => $product->harga_product * $request->qty
                    ]);
                } else {
                    // Jika sudah ada
                    $transaction_detail = TransactionDetail::where('product_id', $product->id_product)
                        ->where('transaction_id', $transaction_id->id_transaksi)->first();
                    // update quantity
                    $transaction_detail->quantity = $transaction_detail->quantity + $request->qty;
                    // update harga baru
                    $total_harga_baru = $product->harga_product * $request->qty;
                    $transaction_detail->total_harga = $transaction_detail->total_harga + $total_harga_baru;
                    $transaction_detail->update();
                }
                // Mencari total harga dengan id transaksi yg sama
                $transaction_detail = TransactionDetail::where('transaction_id', $transaction_id->id_transaksi)->get();
                $total = 0;
                foreach ($transaction_detail as $td) {
                    $total += $td->total_harga;
                }
                // update total gtransaksi
                $transaction_id->update([
                    'total_transaksi' => $total,
                    'tanggal' => $tgl
                ]);
            }
        }

        return redirect('/cart');
    }

    public function updateQty(Request $request, $id)
    {
        $transaction_detail = TransactionDetail::findOrFail($id);
        $transaction = Transaction::where('id_transaksi', $transaction_detail->transaction_id)->first();
        // validasi stock
        if ($request->qty > $transaction_detail->product->stock_product) {
            alert()->warning('Not Enough Stock for This Product', 'Update Failed');
            return back();
        }
        $harga_baru = $transaction_detail->product->harga_product * $request->qty;
        $transaction_detail->update([
            'quantity' => $request->qty,
            'total_harga' => $harga_baru
        ]);
        // Update Total Transaksi
        $transaction_details = TransactionDetail::where('transaction_id', $transaction->id_transaksi)->get();
        $total = 0;
        foreach ($transaction_details as $td) {
            $total += $td->total_harga;
        }
        $transaction->update([
            'total_transaksi' => $total
        ]);
        alert()->success('Ypur Quantity has been Changed', 'Update Success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction_detail = TransactionDetail::findOrFail($id);

        $transaction = Transaction::where('id_transaksi', $transaction_detail->transaction_id)->first();
        $transaction->total_transaksi = $transaction->total_transaksi - $transaction_detail->total_harga;
        $transaction->update();

        $transaction_detail->delete();

        return back();
    }

    public function checkout(Request $request, $id)
    {
        $q = $request->q;
        $province = Province::pluck('name', 'id_province');
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first();

        $transaction = Transaction::findOrFail($id);
        // Update status cart
        $transaction_cart = $transaction->update([
            'is_cart' => 1
        ]);

        $transaction_detail = TransactionDetail::with(['product', 'transaction'])
            ->where('transaction_id', $transaction->id_transaksi)->get();
        foreach ($transaction_detail as $td)
            if ($td->product->stock_product <= 0) {
                alert()->warning('Product Out of Stock', 'Checkout Failed');
                return redirect('/cart');
            }
        $couriers = Courier::all();
        $subtotal = 0;
        foreach ($transaction_detail as $item => $td) {
            $subtotal += $td->total_harga;
        }
        $tax = 0.1 * $subtotal;

        return view('layouts.cart.checkout', compact('q', 'province', 'seller', 'transaction', 'transaction_detail', 'tax', 'subtotal', 'couriers'));
    }

    public function get_ongkir($origin, $destination, $weight, $courier)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&destination=$destination&weight=$weight&courier=$courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 7087d5fca7168d9c6fae6d097671c12c"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);
            $data_ongkir = $response['rajaongkir']['results'];
            return json_encode($data_ongkir);
        }
    }

    // public function get_ongkir()
    // {
    // }

    public function pembayaran($id)
    {
        $user = Customer::where('id', Auth::user()->cust_id)->first();
        $transaction = Transaction::findOrFail($id);
        // transaction detail dengan transaksi id sama dg id transaksi
        $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id_transaksi)->get();

        // update stock
        $subtotal = 0;
        foreach ($transaction_detail as $td) {
            $stock = ($td->product->stock_product) - ($td->quantity);
            $product = Product::where('id_product', $td->product_id)->first();
            $product->update([
                'stock_product' => $stock
            ]);
            $subtotal += $td->total_harga;
        }
        $tax = 0.1 * $subtotal;

        $tanggal = Carbon::now();

        $transaction->update([
            'is_cart' => 2,
            'total_transaksi' => $transaction->total_transaksi + $tax,
            'tanggal' => $tanggal
        ]);

        Mail::to($user->email)->send(new NotifPembayaran($transaction));

        return view('emails.index');
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'id_city');
        return json_encode($city);
    }

    public function form(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->name = $request->name;
        $transaction->phone = $request->phone;
        $transaction->city_id = $request->city;
        $transaction->alamat = $request->alamat;
        $transaction->update();
        // dd($transaction);
        alert()->success('Your Bio has Been Changed', 'Update Success');
        return back();
    }
}
