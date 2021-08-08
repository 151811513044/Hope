<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\City;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Store;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'province' => 'required',
            'city' => 'required',
            'alamat' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'min:10', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'same:password']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        $cust = new Customer;
        $cust->name = $data['nama'];
        $cust->phone = $data['phone'];
        $cust->email = $data['email'];
        $cust->alamat = $data['alamat'];
        $cust->city_id = $data['city'];
        $cust->save();

        $id = Customer::select('id')->orderBy('id', 'desc')->first();
        // dd($id);
        $store = new Store;
        $store->email = $data['email'];
        $store->cust_id = $id->id;
        $store->save();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
            'cust_id' => $id->id
        ]);
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'id_city');
        return json_encode($city);
    }
}
