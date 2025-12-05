<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\CustomerPackageOrder;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request, Package $package)
    {
        if (!$package->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'payment_method' => ['required', 'in:card,bank_transfer'],
        ]);

        $order = CustomerPackageOrder::create([
            'user_id' => Auth::id(),
            'package_id' => $package->id,
            'status' => 'pending_payment',
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'waiting',
            'question_quota' => $package->question_quota,
            'voice_quota' => $package->voice_quota,
            'remaining_question_count' => $package->question_quota,
            'remaining_voice_count' => $package->voice_quota,
        ]);

        // Process payment based on method
        if ($validated['payment_method'] === 'card') {
            // TODO: Implement card payment
            // For now, just mark as paid for testing
            $order->update([
                'status' => 'paid',
                'payment_status' => 'success',
                'paid_at' => now(),
                'starts_at' => now(),
                'expires_at' => now()->addDays($package->validity_days),
            ]);

            return redirect()->route('customer.dashboard')
                ->with('success', 'Paket başarıyla satın alındı!');
        } else {
            // Bank transfer - wait for admin approval
            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Sipariş oluşturuldu. Havale bilgileri için sipariş detay sayfasına bakın.');
        }
    }

    /**
     * Display the specified order.
     */
    public function show(CustomerPackageOrder $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('package');

        return view('customer.orders.show', [
            'order' => $order,
        ]);
    }
}
