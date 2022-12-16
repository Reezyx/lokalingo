<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
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

            return response()->json([
                'code' => 200,
                'info' => "Registered Successfully",
                'data' => $user
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

    public function logout()
    {
        auth('api')->logout();
        return response()->json([
            'code'      => 200,
            'info'      => 'Successfully logged out',
        ], 200);
    }
}
