<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            return response()->json([
                "message" => "Login successful.",
                "user" => $user->createToken('api_token')->plainTextToken
            ]);
        }

        return response()->json([
            "message" => "Invalid credentials."
        ], 401);
    }
}
