<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login_get(Request $request)
    {
        $user = $request->user();
        if ($user)
        {
            return response()->json([
                "ok" => true,
                "user" => $user,
                "message" => "Authenticated"
            ], 200);
        }

        return response()->json([
            "ok" => false,
            "message" => "Unauthorized",
        ], 401);
    }

    public function login_post(Request $request)
    {
        $credentials = $request->validate([
            "email" => ['required', 'email'],
            "password" => ['required']
        ]);

        if (Auth::attempt($credentials))
        {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(
                [
                    "ok" => true,
                    "user" => $user,
                    "token" => $token,
                ],
                200
            );
        }
        return response()->json(["ok" => false, "message" => "credentials are invalid"], 400);
    }

    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($attributes);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(["ok" => true, "user" => $user, "token" => $token], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["ok" => true, "message" => "Logged out"], 200);
    }
}
