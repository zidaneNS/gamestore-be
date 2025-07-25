<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response(['error' => 'Invalid credentials'], 400);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response(["token" => $token]);
    }

    public function register(Request $request)
    {
        $validatedFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'role' =>'required'
        ]);

        if ($request['img_url']) {
            $validatedFields['img_url'] = $request['img_url'];
        }

        $user = User::create($validatedFields);

        return response($user, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response(null, 204);
    }
}
