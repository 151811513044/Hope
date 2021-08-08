<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
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
    public function index()
    {
        $user = User::where('role', 'admin')->get();
        return view('admin.admin.index', compact('user'));
    }

    public function indexCust()
    {
        $customer = Customer::all();
        return view('admin.customer.index', compact('customer'));
    }

    public function indexStore()
    {
        $store = Store::with('customer')->get();
        return view('admin.penjual.index', compact('store'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'same:password']
        ]);

        $user = $request->all();
        $user['role'] = 'admin';
        $user['password'] = bcrypt($request->password);
        $user['email_verified_at'] = new \DateTime();

        User::create($user);

        return back()->with('status', 'Data Admin Berhasil di Tambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        Store::where('cust_id', $id)->delete();
        User::where('cust_id', $id)->delete();

        return back()->with('status', 'Data berhasil di Hapus');
    }

    public function destroyStore($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        // dd($store);

        $data = User::where('cust_id', $store->cust_id)->update([
            'role' => 'customer'
        ]);

        return back()->with('status', 'Data Berhasil di Hapus');
    }
}
