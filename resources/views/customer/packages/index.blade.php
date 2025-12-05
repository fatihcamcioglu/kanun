@extends('customer.layouts.app')

@section('title', 'Paketler')

@section('content')
    <div class="page-header">
        <h1>Paketler</h1>
        <p>Size uygun paketi seçin ve soru sormaya başlayın</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
        @foreach($packages as $package)
            <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column;">
                <h3 style="color: #1f2937; font-size: 20px; font-weight: 700; margin-bottom: 12px;">{{ $package->name }}</h3>
                <div style="margin-bottom: 20px; flex-grow: 1;">
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                        <strong>Soru Hakkı:</strong> {{ $package->question_quota }}
                    </div>
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                        <strong>Ses Hakkı:</strong> {{ $package->voice_quota }}
                    </div>
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                        <strong>Geçerlilik:</strong> {{ $package->validity_days }} gün
                    </div>
                </div>
                <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                    <div style="font-size: 28px; font-weight: 700; color: #f59e0b; margin-bottom: 16px;">
                        {{ number_format($package->price, 2) }} {{ $package->currency }}
                    </div>
                    <a href="{{ route('customer.packages.show', $package) }}" class="btn btn-primary" style="width: 100%; text-align: center;">Satın Al</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection

