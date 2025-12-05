<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If user is already authenticated and is a customer, redirect to dashboard
        if (Auth::check() && Auth::user()->role === 'CUSTOMER') {
            return redirect()->route('customer.dashboard');
        }

        return view('landing.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Check if user is customer
            if ($user->role !== 'CUSTOMER') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Bu sayfa sadece müşteriler içindir.',
                ])->onlyInput('email');
            }

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz bilgiler kayıtlarımızla eşleşmiyor.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }
}
