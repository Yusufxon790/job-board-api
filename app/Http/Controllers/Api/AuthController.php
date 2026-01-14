<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $validated = $request->validated();

        $validated['password'] = Hash::make($request->password);
        $user = User::create($validated);

        $token = $user->createToken('main_token')->plainTextToken;

        return response()->json(['user'=>$user,'token'=>$token],201);
    }

    public function login(LoginRequest $request){
        $validated = $request->validated();

        $user = User::where('email',$request->email)->first();

        if(! $user || ! Hash::check($request->password,$user->password)){
            return response()->json(['message' => 'Login yoki parol xato!'],401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('main_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Tizimdan chiqildi.']);
    }
}
