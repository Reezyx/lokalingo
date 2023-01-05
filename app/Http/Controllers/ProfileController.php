<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth('api')->user();

        return response()->json([
            'code' => '200',
            'info' => 'Get Profile Success',
            'data' => $user
        ]);
    }

    public function updateProfile(UpdateProfilRequest $request)
    {
        $user = auth('api')->user();
        $userProfile = User::find($user->id);
        $userProfile->full_name = $request->full_name;
        $userProfile->username = $request->username;
        $userProfile->email = $request->email;
        $userProfile->password = Hash::make($request->password);
        $userProfile->save();

        return response()->json([
            'code' => 200,
            'info' => 'Update Profile Success',
            'user' => $userProfile,
        ]);
    }
}
