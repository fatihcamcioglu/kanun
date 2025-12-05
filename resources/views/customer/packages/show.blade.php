@extends('customer.layouts.app')

@section('title', $package->name . ' - Paket Detay')

@section('content')
    <div class="page-header">
        <h1>{{ $package->name }}</h1>
        <p>Paket detayları ve satın alma</p>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h2 style="color: #1f2937; font-size: 20px; font-weight: 600; margin-bottom: 20px;">Paket Özellikleri</h2>
            <div style="margin-bottom: 16px;">
                <strong style="color: #1f2937;">Soru Hakkı:</strong>
                <span style="color: #6b7280; margin-left: 8px;">{{ $package->question_quota }} soru</span>
            </div>
            <div style="margin-bottom: 16px;">
                <strong style="color: #1f2937;">Ses Hakkı:</strong>
                <span style="color: #6b7280; margin-left: 8px;">{{ $package->voice_quota }} ses</span>
            </div>
            <div style="margin-bottom: 16px;">
                <strong style="color: #1f2937;">Geçerlilik Süresi:</strong>
                <span style="color: #6b7280; margin-left: 8px;">{{ $package->validity_days }} gün</span>
            </div>
        </div>

        <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h2 style="color: #1f2937; font-size: 20px; font-weight: 600; margin-bottom: 20px;">Satın Al</h2>
            <div style="font-size: 32px; font-weight: 700; color: #f59e0b; margin-bottom: 24px; text-align: center;">
                {{ number_format($package->price, 2) }} {{ $package->currency }}
            </div>

            <form method="POST" action="{{ route('customer.orders.store', $package) }}">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 500;">Ödeme Yöntemi</label>
                    <select name="payment_method" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
                        <option value="card">Kredi/Banka Kartı</option>
                        <option value="bank_transfer">Havale/EFT</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Satın Al</button>
            </form>
        </div>
    </div>
@endsection

