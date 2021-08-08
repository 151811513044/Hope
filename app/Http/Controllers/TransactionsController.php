<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Mail\NotifOrder;
use App\Mail\TransactionFailed;
use App\Mail\TransactionSuccess;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade as PDF;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $transaction = Transaction::with('details')->where('is_cart', 2)->where('status', 'PENDING')->orderBy('tanggal', 'desc')->get();

        return view('admin.transaction.admin.index', compact('transaction'));
    }
    public function indexSeller(Request $request, $id)
    { //Menampilkan data product yang laku terjual dari toko seller yg login
        $user = User::findOrFail($id);
        // ambil data seller yg sedang login
        $seller = Store::where('cust_id', $user->cust_id)->first(); //store_id
        if (empty($seller)) {
            return redirect('/product');
        }
        // ambil data transaksi yang sukses
        $transaction = Transaction::where('status', 'SUCCESS')->get();
        // dd($transaction->first());
        if ($transaction->first() == null) {
            alert()->info('There is No Transaction', 'Failed Open');
            return redirect('/dashboard');
        }

        // Transaction Pertanggal
        $startDate = $request->input('tglawal');
        $endDate = $request->input('tglakhir');

        if ($startDate && !$endDate) {
            Session::flash('error', 'Tanggal akhir harus diisi');
            return redirect('/transaction/' . $id);
        }

        if (!$startDate && $endDate) {
            Session::flash('error', 'Tanggal awal harus diisi');
            return redirect('/transaction/' . $id);
        }

        if ($startDate && $endDate) {
            if (strtotime($endDate) < strtotime($startDate)) {
                Session::flash('error', 'Tanggal awal harus sama atau lebih besar dari tanggal akhir');
                return redirect('/transaction/' . $id);
            }

            $earlier = new \DateTime($startDate);
            $later = new \DateTime($endDate);
            $diff = $later->diff($earlier)->format("%a");

            if ($diff >= 31) {
                Session::flash('error', 'Range tanggal harus kurang dari atau sama dengan 31');
                return redirect('/transaction/' . $id);
            }
        } else {
            $transaction_detail = TransactionDetail::select('transaction_details.*', 'trans.tanggal', 'trans.uuid', 'trans.name', 'prod.nama_product')
                ->join('transactions as trans', 'trans.id_transaksi', '=', 'transaction_details.transaction_id')
                ->join('products as prod', 'prod.id_product', '=', 'transaction_details.product_id')
                ->where('trans.status', 'SUCCESS')->where('prod.store_id', $seller->id)->where('transaction_details.deleted_at', null)
                ->get();
            $currentDate = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime($transaction_detail->first()->tanggal));
            $endDate = date('Y-m-t', strtotime($currentDate));
        }

        $transaction_detail = TransactionDetail::select('transaction_details.*', 'trans.tanggal', 'trans.uuid', 'trans.name', 'prod.nama_product')
            ->join('transactions as trans', 'trans.id_transaksi', '=', 'transaction_details.transaction_id')
            ->join('products as prod', 'prod.id_product', '=', 'transaction_details.product_id')
            ->where('trans.status', 'SUCCESS')->where('prod.store_id', $seller->id)->where('transaction_details.deleted_at', null)
            ->whereBetween('trans.tanggal', [$startDate, $endDate])
            ->orderBy('trans.tanggal', 'desc')->get();

        $total_harga = TransactionDetail::select(DB::raw('sum(total_harga) as harga'))
            ->join('transactions as trans', 'trans.id_transaksi', '=', 'transaction_details.transaction_id')
            ->join('products as prod', 'prod.id_product', '=', 'transaction_details.product_id')
            ->where('trans.status', 'success')->where('prod.store_id', $seller->id)->where('transaction_details.deleted_at', null)
            ->whereBetween('trans.tanggal', [$startDate, $endDate])
            ->get();

        if ($exportAs = $request->export) {
            if (!in_array($exportAs, ['xlsx', 'pdf'])) {
                Session::flash('error', 'Invalid export request');
                return redirect('/transaction/' . $id);
            }
            if ($exportAs == 'xlsx') {
                $fileName = 'report-transaction-' . $startDate . '-' . $endDate . '.xlsx';

                return Excel::download(new TransactionExport($transaction_detail), $fileName);
            }

            if ($exportAs == 'pdf') {
                $fileName = 'report-transaction-' . $startDate . '-' . $endDate . '.pdf';
                $pdf = PDF::loadView('admin.laporan.transaction_pdf', compact('transaction_detail', 'startDate', 'endDate', 'total_harga'));
                // alert()->success('PDF automatically downloaded', 'Export Success');
                return $pdf->download($fileName);
            }
        }


        return view('admin.transaction.mix.index', compact('transaction_detail', 'transaction'));
    }
    public function success()
    {
        $transaction = Transaction::with('details')->where('status', 'SUCCESS')->where('is_cart', 3)->orderBy('tanggal', 'desc')->get();

        return view('admin.transaction.admin.success', compact('transaction'));
    }
    public function failed()
    {
        $transaction = Transaction::with('details')->where('status', 'FAILED')->where('is_cart', 3)->orderBy('tanggal', 'desc')->get();

        return view('admin.transaction.admin.failed', compact('transaction'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $detail = Transaction::with('details.product')->findOrFail($id);

        return view('admin.transaction.admin.show', compact('detail'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function pembayaran($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction_detail = TransactionDetail::with(['product', 'transaction'])->where('transaction_id', $transaction->id_transaksi)->get();
        $payments = Payment::with('transaction')->where('transaction_id', $transaction->id_transaksi)->get();

        $subtotal = 0;
        foreach ($transaction_detail as $td) {
            $subtotal += $td->total_harga;
        }
        $tax = $subtotal * 0.1;

        return view('admin.transaction.admin.pembayaran', compact('transaction_detail', 'transaction', 'payments', 'subtotal', 'tax'));
    }

    public function getPreview($id)
    {
        $file = Payment::where('id_payment', $id)->first();
        $filename = $file->bukti_pembayaran;
        $ext = explode('.', $file->bukti_pembayaran);

        return Response::make(Storage::disk('public')->get('/images/bukti_pembayaran/' . $filename), 200, [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function setStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:SUCCESS,PENDING,FAILED'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;

        $transaction->save();

        return back();
    }

    public function validasiPembayaran($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->status = 1;
        $payment->update();

        $transaction = Transaction::where('id_transaksi', $payment->transaction_id)->first();
        $transaction->update([
            'status' => "SUCCESS",
            'is_cart' => 3
        ]);

        Mail::to($transaction->customer->email)->send(new TransactionSuccess($transaction));

        $transaction_detail = TransactionDetail::with(['transaction', 'product'])->where('transaction_id', $transaction->id_transaksi)->get();
        $data = [];
        foreach ($transaction_detail as $td) {
            $data[] = $td->product->store->email;
        }
        $email = array_unique($data);
        foreach ($email as $mail) {
            Mail::to($mail)->send(new NotifOrder($transaction_detail));
        }

        alert()->success('Payment is Valid and Transaction Success', 'Payment Success');
        return back();
    }
    public function setFailed(Request $request, $id)
    {
        $payment = Payment::where('id_payment', $id)->first();
        $transaction = Transaction::with('customer')->where('id_transaksi', $payment->transaction_id)->first();
        $transaction->update([
            'status' => "FAILED",
            'is_cart' => 3,
            'alasan' => $request->alasan
        ]);
        $transaction_detail = TransactionDetail::where('transaction_id', $transaction->id_transaksi)->get();
        foreach ($transaction_detail as $td) {
            $product = Product::where('id_product', $td->product_id)->first();
            $product->update([
                'stock_product' => $product->stock_product + $td->quantity
            ]);
        }
        Mail::to($transaction->customer->email)->send(new TransactionFailed($transaction, $payment));
        alert()->warning('Payment is inValid and Transaction Failed', 'Payment Failed');
        return back();
    }
}
