<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $accessToken = $user->createToken('API Token')->accessToken;
            return response()->json(['access_token' => $accessToken], 200);
        }
        return response()->json(['error' => 'email ou mot de passe incorrect'], 422);
    }


    
    public function Dashboard()
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();

            return response()->json(['user' => $user]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();
        $request->user()->tokens()->delete(); 
        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

}
