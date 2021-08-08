<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
        // admin
        $user = User::whereNotNull('cust_id')->count();
        $transaksi = Transaction::where('status', 'SUCCESS')->sum('total_transaksi');
        $sales = Transaction::where('status', 'success')->count();
        $pie = [
            'pending' => Transaction::where('status', 'PENDING')->count(),
            'failed' => Transaction::where('status', 'FAILED')->count(),
            'success' => Transaction::where('status', 'SUCCESS')->count()
        ];
        $users = User::select(DB::raw("COUNT(*) as count"))
            ->whereNotNull('cust_id')
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("Month(created_at)"))
            ->pluck('count');
        $months = User::select(DB::raw('Month(created_at) as month'))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('Month(created_at)'))
            ->pluck('month');
        $datas = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($months as $index => $month) {
            $datas[$month - 1] = $users[$index];
        }

        return view('admin.layout.dashboard', compact('user', 'transaksi', 'sales', 'pie', 'datas'));
    }

    public function indexSeller()
    {
        // Mix
        $seller = Store::where('cust_id', Auth::user()->cust_id)->first(); //store_id
        if (empty($seller)) {
            return redirect('/home');
        }
        $transaction_detail = DB::table('transaction_details')
            ->join('transactions as trans', 'trans.id_transaksi', '=', 'transaction_details.transaction_id')
            ->join('products as prod', 'prod.id_product', '=', 'transaction_details.product_id')
            ->where('trans.status', 'success')->where('prod.store_id', $seller->id)->where('transaction_details.deleted_at', null)
            ->get();
        // Notif total penghasilan dan product sold
        $total_harga = TransactionDetail::select(DB::raw('sum(quantity) as qty'), DB::raw('sum(total_harga) as harga'))
            ->join('transactions as trans', 'trans.id_transaksi', '=', 'transaction_details.transaction_id')
            ->join('products as prod', 'prod.id_product', '=', 'transaction_details.product_id')
            ->where('trans.status', 'success')->where('prod.store_id', $seller->id)->where('transaction_details.deleted_at', null)
            ->get();
        if ($transaction_detail->first() != null) {
            // // Chart
            $trans = TransactionDetail::select(DB::raw('count(*) as count'))
                ->join('transactions as trans', 'trans.id_transaksi', '=', 'transaction_details.transaction_id')
                ->join('products as prod', 'prod.id_product', '=', 'transaction_details.product_id')
                ->where('trans.status', 'success')->where('prod.store_id', Auth::user()->cust_id)->where('transaction_details.deleted_at', null)
                ->whereYear('trans.tanggal', date('Y'))
                ->groupBy(DB::raw('Month(trans.tanggal)'))
                ->pluck('count');
            $months = Transaction::select(DB::raw('Month(tanggal) as month'))
                ->whereYear('tanggal', date('Y'))
                ->groupBy(DB::raw('Month(tanggal)'))
                ->pluck('month');
            $min = min(count($trans), count($months));
            $data_trans = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($months as $index => $month) {
                $data_trans[$month - 1] = $trans[($index)];
            }
        } else {
            $data_trans = [];
        }
        return view('admin.layout.dashboard-seller', compact('transaction_detail', 'total_harga', 'data_trans'));
    }

    public function getYear(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        return view('profile.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required'
        ]);

        $currentPassword = auth()->user()->password;
        $old_password = $request->old_password;

        // dd($request);
        if (Hash::check($old_password, $currentPassword)) {

            Auth::user()->id->update([
                'password' => bcrypt($request->password),
            ]);

            return back()->with('success', 'Password changed successfully');
        } elseif (strcmp($request->get('old_password'), $request->get('password')) == 0) {
            // Current password and new password are same
            return redirect()->back()->withErrors(['old_password' => 'New Password cannot be same as your current password. Please choose a different password.']);
        } else {
            return back()->withErrors(['old_password' => 'Your current password does not matches with the password you provided. Please try again.']);
        }
    }
}
