<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->akses == 'admin') {
            return redirect()->route('admin.beranda');
        } elseif ($user->akses == 'operator') {
            return redirect()->route('operator.beranda');
        } else {
            Auth::user()->logout();
            flash('Anda tidak memiliki hak akses')->error();
            return redirect()->route('login');
        }
    }

    public function loginApi(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->akses == 'admin') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login Berhasil',
                    'user' => $user,
                    'token' => $user->createToken('nApp')->plainTextToken,
                ], 200);
            } elseif ($user->akses == 'operator') {
                return response()->json([
                    'success' => true,
                    'message' => 'Login Berhasil',
                    'user' => $user,
                    'token' => $user->createToken('nApp')->plainTextToken,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki hak akses',
                ], 401);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Gagal',
            ], 401);
        }
    }

}
