@extends('customer.layouts.app')

@section('title', 'Sipariş Detay')

@section('content')
    <div class="page-header">
        <h1>Sipariş Detay</h1>
        <p>Sipariş #{{ $order->id }}</p>
    </div>

    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); max-width: 600px;">
        <div style="margin-bottom: 24px;">
            <h2 style="color: #1f2937; font-size: 20px; font-weight: 600; margin-bottom: 16px;">{{ $order->package->name }}</h2>
            <div style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                <strong>Durum:</strong> 
                @if($order->status === 'paid')
                    <span style="color: #065f46;">Ödendi</span>
                @elseif($order->status === 'pending_payment')
                    <span style="color: #92400e;">Ödeme Bekliyor</span>
                @else
                    <span>{{ $order->status }}</span>
                @endif
            </div>
            <div style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                <strong>Ödeme Yöntemi:</strong> {{ $order->payment_method === 'card' ? 'Kredi/Banka Kartı' : 'Havale/EFT' }}
            </div>
            <div style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                <strong>Ödeme Durumu:</strong> {{ $order->payment_status === 'success' ? 'Başarılı' : 'Bekliyor' }}
            </div>
        </div>

        @if($order->payment_method === 'bank_transfer' && $order->status === 'pending_payment')
            <div style="background: #fef3c7; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <h3 style="color: #92400e; font-size: 16px; font-weight: 600; margin-bottom: 12px;">Havale/EFT Bilgileri</h3>
                <p style="color: #92400e; font-size: 14px; margin-bottom: 8px;">
                    Lütfen aşağıdaki hesaba ödemenizi yapın ve dekontu yükleyin.
                </p>
                <div style="color: #92400e; font-size: 14px;">
                    <strong>Banka:</strong> Örnek Banka<br>
                    <strong>IBAN:</strong> TR00 0000 0000 0000 0000 0000 00<br>
                    <strong>Tutar:</strong> {{ number_format($order->package->price, 2) }} {{ $order->package->currency }}
                </div>
            </div>
        @endif

        @if($order->status === 'paid')
            <div style="background: #d1fae5; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                <p style="color: #065f46; font-size: 14px;">
                    Paketiniz aktif! Soru sormaya başlayabilirsiniz.
                </p>
            </div>
        @endif
    </div>
@endsection

