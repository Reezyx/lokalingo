<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Utilities\StatusUtilities;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/login';

    public function adminLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect($this->redirectTo);
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function adminLogin(Request $request)
    {
        $credentialsEmail   = [
            'email'     => $request->email,
            'password'  => $request->password
        ];

        if (!$this->guard()->attempt($credentialsEmail)) {
            return response()->json([
                'code' => StatusUtilities::FAILED,
                'info' => 'Email atau Password yang anda masukkan salah'
            ]);
        }
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        return response()->json([
            'code'          => StatusUtilities::SUCCESS,
            'info'          => "Login berhasil",
            'data'          => [
                'url'       => route('dashboard.index')
            ],
        ]);
    }
}
