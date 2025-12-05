@extends('customer.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-header">
        <h1>Dashboard</h1>
        <p>Hoş geldiniz, {{ $user->name }}</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 30px;">
        <div class="stat-card" style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Toplam Sipariş</h3>
            <div class="value" style="color: #1f2937; font-size: 32px; font-weight: 700;">{{ $orders->count() }}</div>
        </div>
        <div class="stat-card" style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Aktif Paket</h3>
            <div class="value" style="color: #1f2937; font-size: 20px; font-weight: 700;">{{ $activeOrder ? $activeOrder->package->name : 'Yok' }}</div>
        </div>
        <div class="stat-card" style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Toplam Soru</h3>
            <div class="value" style="color: #1f2937; font-size: 32px; font-weight: 700;">{{ $questions->count() }}</div>
        </div>
        <div class="stat-card" style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
            <h3 style="color: #6b7280; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Kalan Soru Hakkı</h3>
            <div class="value" style="color: #1f2937; font-size: 32px; font-weight: 700;">{{ $activeOrder ? $activeOrder->remaining_question_count : 0 }}</div>
        </div>
    </div>

    <div class="section" style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <h2 style="color: #1f2937; font-size: 20px; font-weight: 600; margin-bottom: 20px;">Son Sorularım</h2>
        @if($questions->count() > 0)
            @foreach($questions->take(5) as $question)
                <div class="question-item" style="padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; margin-bottom: 12px;">
                    <h4 style="color: #1f2937; font-size: 16px; font-weight: 600; margin-bottom: 8px;">
                        <a href="{{ route('customer.questions.show', $question) }}" style="text-decoration: none; color: inherit;">{{ $question->title }}</a>
                    </h4>
                    <div class="question-meta" style="color: #6b7280; font-size: 14px; display: flex; gap: 16px;">
                        <span>Kategori: {{ $question->category->name }}</span>
                        <span>Durum: 
                            <span class="status status-{{ $question->status === 'answered' ? 'answered' : 'waiting' }}" style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; background: {{ $question->status === 'answered' ? '#d1fae5' : '#fef3c7' }}; color: {{ $question->status === 'answered' ? '#065f46' : '#92400e' }};">
                                @if($question->status === 'waiting_assignment')
                                    Atama Bekliyor
                                @elseif($question->status === 'waiting_lawyer_answer')
                                    Cevap Bekliyor
                                @elseif($question->status === 'answered')
                                    Cevaplandı
                                @else
                                    Kapalı
                                @endif
                            </span>
                        </span>
                        @if($question->assignedLawyer)
                            <span>Avukat: {{ $question->assignedLawyer->name }}</span>
                        @endif
                    </div>
                </div>
            @endforeach
            <div style="text-align: center; margin-top: 20px;">
                <a href="{{ route('customer.questions.index') }}" class="btn btn-primary">Tüm Soruları Gör</a>
            </div>
        @else
            <div class="empty-state" style="text-align: center; padding: 40px; color: #6b7280;">
                <p>Henüz soru sormadınız.</p>
                <a href="{{ route('customer.questions.create') }}" class="btn btn-primary" style="margin-top: 20px;">İlk Sorunuzu Sorun</a>
            </div>
        @endif
    </div>

    @if(!$activeOrder)
        <div class="section" style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 30px; text-align: center;">
            <h2 style="color: #1f2937; font-size: 20px; font-weight: 600; margin-bottom: 12px;">Aktif Paketiniz Yok</h2>
            <p style="color: #6b7280; margin-bottom: 20px;">Soru sorabilmek için bir paket satın almanız gerekiyor.</p>
            <a href="{{ route('customer.packages.index') }}" class="btn btn-primary">Paketleri Görüntüle</a>
        </div>
    @endif
@endsection

