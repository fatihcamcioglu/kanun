<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        // If user is already authenticated and is a customer, redirect to dashboard
        if (Auth::check() && Auth::user()->role === 'CUSTOMER') {
            return redirect()->route('customer.dashboard');
        }

        return view('landing.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'CUSTOMER',
            'phone' => $validated['phone'] ?? null,
            'status' => 'active',
        ]);

        Auth::login($user);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Hesabınız başarıyla oluşturuldu!');
    }
}
