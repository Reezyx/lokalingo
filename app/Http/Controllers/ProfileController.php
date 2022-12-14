<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
