<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BuyerServices;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthUser extends Controller
{
    public function LoginPage()
    {
        BuyerServices::orderExpired();
        return view('page.login');
    }
    public function RegisterPage()
    {
        return view('page.register');
    }

    public function Login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $user = Auth::user();
            session(['auth' => [
                'email' => $user->email,
                'role' => $user->role,
            ]]);
            return match ($user->role) {
                'admin', 'cslayer1', 'cslayer2' => redirect()->route('admin'),
                'buyer' => redirect()->route('buyer'),
                default => redirect()->route('home'),
            };
        }
        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ]);
    }

    public function Register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:255',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'address' => $validated['address'],
            'role' => 'buyer',
        ]);
        return redirect()->route('page.login')->with('success', 'Register Successful');
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('page.login');
    }
}
