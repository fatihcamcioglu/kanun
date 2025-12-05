<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure user is customer
        if ($user->role !== 'CUSTOMER') {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        $orders = $user->orders()->with('package')->latest()->get();
        $activeOrder = $orders->where('status', 'paid')->first();
        $questions = $user->legalQuestions()->with(['category', 'assignedLawyer'])->latest()->get();

        return view('customer.dashboard', [
            'user' => $user,
            'orders' => $orders,
            'activeOrder' => $activeOrder,
            'questions' => $questions,
        ]);
    }
}
