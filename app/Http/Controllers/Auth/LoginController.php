<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin':
                return '/dashboard';
                break;
            case 'customer':
                return '/home';
                break;
            case 'mix':
                return '/home';
                break;
            default:
                return '/';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function postLogin(Request $request)
    {
        $this->validateLogin($request);
        // dd($request);
        if (Auth::attempt($request->only('email', 'password'))) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('dashboard');
            } else if (Auth::user()->role == 'mix') {
                return redirect()->route('home');
            } elseif (Auth::user()->role == 'customer') {
                return redirect()->route('home');
            }
        }
        session()->flash('error', 'Invalid Email or Password');
        return redirect('/login');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
}
