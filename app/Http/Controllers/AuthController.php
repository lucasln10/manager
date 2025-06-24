<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)){
            return response()->json(['erro' => 'Credenciais Invalidas']);
        }

        return response()->json([
            'access_token' =>  $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Logout feito com sucesso']);
    }

    public function refresh()
    {
        return response()->json([
           'access_token' => auth('api')->refresh(),
           'token_type' => 'bearer',
           'expires_in' => auth('api')->factory()->getTTL() * 60 
        ]);
    }
}
