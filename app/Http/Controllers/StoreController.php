<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Store;

class StoreController extends Controller
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

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'id_city');
        return json_encode($city);
    }

    public function registerSeller($id)
    {
        $user = User::findOrFail($id);
        $seller = Store::where('cust_id', $user->cust_id)->get();
        $province = Province::pluck('name', 'id_province');
        return view('auth.regst-seller', compact('province', 'seller'));
    }

    public function storeSeller(Request $request, $id)
    {
        $seller = Store::findOrFail($id);
        // dd($seller);
        $seller->update([
            'name' => $request->name,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
            'city_id' => $request->city,
        ]);

        User::where('cust_id', $seller->cust_id)->update([
            'role' => 'mix'
        ]);

        return redirect('/dashboard');
    }
}
