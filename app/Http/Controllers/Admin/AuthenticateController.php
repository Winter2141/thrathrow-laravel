<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\AdminRouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthenticateController extends Controller
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


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = AdminRouteServiceProvider::ADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login_form()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $email    = $request->has('email') ? $request->email : '';
        $password    = $request->has('password') ? $request->password : '';

        if(Auth::attempt(['email' => $email, 'password' => $password]))
        {
            return redirect()->intended('admin/home');
        }else{
            return redirect()->back()->with('error', __('Incorrect Email or Password'));
        }
    }
}
