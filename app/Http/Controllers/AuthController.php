<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginGoogleRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Utilities\StatusUtilities;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $registeredUser = User::where('email', $request->email)->first();
            if (!empty($registeredUser)) {
                return response()->json([
                    'code' => 500,
                    'info' => 'Email telah digunakan sebelumnya'
                ], 500);
            }
            $user = User::create([
                "full_name" => $request->full_name,
                "username" => $request->username,
                "email" => $request->email,
                "role" => 'user',
                "password" => Hash::make($request->password),
                "asal" => $request->asal,
            ]);
            DB::commit();

            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            $token = auth('api')->attempt($credentials);
            $data['user'] = $user;
            $cred = [
                'type' => 'bearer',
                'token' => $token,
                'lifetime' => auth('api')->factory()->getTTL() * 60,
            ];
            $data['token'] = $cred;

            return response()->json([
                'code' => 200,
                'info' => "Registered Successfully",
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug("error register");
            Log::error($e);
            return response()->json([
                'code' => 500,
                'info' => "Register Failed",
                'data' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];
        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'code' => 400,
                'info' => 'Username atau Password salah',
            ], 400);
        }
        $user = auth('api')->user();
        $data['user'] = $user;
        $cred = [
            'type' => 'bearer',
            'token' => $token,
            'lifetime' => auth('api')->factory()->getTTL() * 60,
        ];
        $data['token'] = $cred;

        return response()->json([
            'code' => 200,
            'info' => 'Login successful',
            'data' => $data
        ], 200);
    }

    public function googleLogin(LoginGoogleRequest $request)
    {
        $checkUser = User::where('email', $request->email)->first();
        if ($checkUser) {
            $credentials = [
                "email" => $checkUser->email,
                "password" => $checkUser->google_id
            ];
            $user = $checkUser;
            $token = auth('api')->attempt($credentials);
        } else {
            $user = User::create([
                "email"     => $request->email,
                "full_name" => $request->name,
                "google_id" => $request->google_id,
                "password"  => Hash::make($request->google_id),
            ]);

            $credentials = [
                "email" => $request->email,
                "password" => $request->google_id
            ];

            $token = auth('api')->attempt($credentials);
        }

        $data['user'] = $user;
        $cred = [
            'type' => 'bearer',
            'token' => $token,
            'lifetime' => auth('api')->factory()->getTTL() * 60,
        ];
        $data['token'] = $cred;

        return response()->json([
            'code' => 200,
            'info' => 'Login successful',
            'data' => $data
        ], 200);
    }


    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'code'      => 200,
            'info'      => 'Successfully logged out',
        ], 200);
    }
}
