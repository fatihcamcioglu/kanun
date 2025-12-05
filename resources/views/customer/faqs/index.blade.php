@extends('customer.layouts.app')

@section('title', 'Sıkça Sorulan Sorular')

@push('styles')
<style>
    .faqs-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .faq-item {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s;
    }
    .faq-item:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .faq-question {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 12px;
        display: flex;
        align-items: start;
        gap: 12px;
    }
    .faq-question::before {
        content: "Q";
        background: #f59e0b;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }
    .faq-answer {
        color: #4b5563;
        line-height: 1.8;
        font-size: 15px;
        margin-left: 44px;
    }
    .faq-answer::before {
        content: "A:";
        font-weight: 600;
        color: #f59e0b;
        margin-right: 8px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .empty-state-icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 16px;
    }
    .empty-state h3 {
        color: #6b7280;
        font-size: 20px;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: #9ca3af;
        font-size: 14px;
    }
    .ask-question-section {
        text-align: center;
        margin-top: 40px;
        padding: 40px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .ask-question-section h3 {
        color: #1f2937;
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 16px;
    }
    .ask-question-section p {
        color: #6b7280;
        font-size: 15px;
        margin-bottom: 24px;
    }
    .ask-question-btn {
        display: inline-block;
        padding: 14px 32px;
        background: #f59e0b;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
    }
    .ask-question-btn:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
</style>
@endpush

@section('content')
<div class="faqs-container">
    <div class="page-header">
        <h1>Sıkça Sorulan Sorular</h1>
        <p>Merak ettiğiniz soruların cevaplarını burada bulabilirsiniz.</p>
    </div>

    @if($faqs->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">❓</div>
            <h3>Henüz soru eklenmemiş</h3>
            <p>Yakında burada sıkça sorulan soruları bulabileceksiniz.</p>
        </div>
    @else
        @foreach($faqs as $faq)
            <div class="faq-item">
                <div class="faq-question">
                    {{ $faq->question }}
                </div>
                <div class="faq-answer">
                    {!! $faq->answer !!}
                </div>
            </div>
        @endforeach
        
        <div class="ask-question-section">
            <h3>Soru sormak ister misiniz?</h3>
            <p>Aradığınız cevabı bulamadıysanız, avukatlarımıza doğrudan soru sorabilirsiniz.</p>
            <a href="{{ route('customer.questions.create') }}" class="ask-question-btn">Soru Sor</a>
        </div>
    @endif
</div>
@endsection

