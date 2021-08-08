<?php

namespace App\Http\Controllers;

use App\Exports\RevenueReport;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexSeller(Request $request)
    {
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first(); //store_id

        $startDate = $request->input('tglawal');
        $endDate = $request->input('tglakhir');

        if ($startDate && !$endDate) {
            Session::flash('error', 'Tanggal akhir harus diisi');
            return redirect('/report');
        }

        if (!$startDate && $endDate) {
            Session::flash('error', 'Tanggal awal harus diisi');
            return redirect('/report');
        }

        if ($startDate && $endDate) {
            if (strtotime($endDate) < strtotime($startDate)) {
                Session::flash('error', 'Tanggal awal harus sama atau lebih besar dari tanggal akhir');
                return redirect('/report');
            }

            $earlier = new \DateTime($startDate);
            $later = new \DateTime($endDate);
            $diff = $later->diff($earlier)->format("%a");

            if ($diff >= 31) {
                Session::flash('error', 'Range tanggal harus kurang dari atau sama dengan 31');
                return redirect('/report');
            }
        } else {
            $currentDate = date('Y-m-d');
            $startDate = date('Y-m-01', strtotime($currentDate));
            $endDate = date('Y-m-t', strtotime($currentDate));
        }

        $revenues = TransactionDetail::select(
            DB::raw('count(id_transaction_detail) as transaksi'),
            DB::raw('sum(total_harga) as harga'),
            DB::raw('sum(quantity) as qty'),
            'trans.tanggal'
        )->join('products as prod', 'prod.id_product', 'transaction_details.product_id')
            ->join('transactions as trans', 'trans.id_transaksi', 'transaction_details.transaction_id')
            ->where('trans.status', 'success')->where('prod.store_id', $seller->id)->where('transaction_details.deleted_at', null)
            ->whereBetween('trans.tanggal', [$startDate, $endDate])
            ->groupBy(DB::raw('Date(trans.tanggal)'))
            ->get();

        if ($exportAs = $request->export) {
            if (!in_array($exportAs, ['xlsx', 'pdf'])) {
                Session::flash('error', 'Invalid export request');
                return redirect('/report');
            }
            if ($exportAs == 'xlsx') {
                $fileName = 'laporan-pendapatan-' . $startDate . '-' . $endDate . '.xlsx';

                return Excel::download(new RevenueReport($revenues), $fileName);
            }

            if ($exportAs == 'pdf') {
                $fileName = 'laporan-pendapatan-' . $startDate . '-' . $endDate . '.pdf';
                $pdf = PDF::loadView('admin.laporan.revenue_pdf', compact('revenues', 'startDate', 'endDate'));
                // alert()->success('PDF automatically downloaded', 'Export Success');
                return $pdf->download($fileName);
            }
        }
        return view('admin.laporan.revenue', compact('revenues', 'startDate', 'endDate'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
