<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('authentication.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        session(['access_token' => $token]);

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->session()->forget('access_token');
        
        Auth::logout();
        return redirect('/login');
    }

    public function userProfile(Request $request)
    {
        return response()->json($request->user());
    }
}
