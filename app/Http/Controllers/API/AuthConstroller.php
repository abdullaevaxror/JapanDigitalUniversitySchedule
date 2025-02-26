<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthConstroller extends Controller
{
    public function register(Request $request)
    {
        $validator = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' =>  'required|string|min:6'
        ]);
        User::query()->create($validator);

        return response()->json(['message' => 'User created successfully.'], 201);

    }
    public function login(Request $request)
    {
        $validator = $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $validator['email'])->first();

        if (!$user || !Hash::check($validator['password'], $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect'], 401);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successfully',
            'token' => $token,
            'user' => $user
        ], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout successfully'], 201);
    }
}
