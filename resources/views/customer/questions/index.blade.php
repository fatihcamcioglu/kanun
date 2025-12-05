@extends('customer.layouts.app')

@section('title', 'Sorularım')

@section('content')
    <div class="page-header">
        <h1>Sorularım</h1>
        <p>Tüm sorularınızı buradan görüntüleyebilirsiniz</p>
    </div>

    @if($questions->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @foreach($questions as $question)
                <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <h3 style="color: #1f2937; font-size: 18px; font-weight: 600; margin: 0;">
                            <a href="{{ route('customer.questions.show', $question) }}" style="text-decoration: none; color: inherit;">{{ $question->title }}</a>
                        </h3>
                        <span class="status status-{{ $question->status === 'answered' ? 'answered' : 'waiting' }}" style="display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; background: {{ $question->status === 'answered' ? '#d1fae5' : '#fef3c7' }}; color: {{ $question->status === 'answered' ? '#065f46' : '#92400e' }};">
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
                    </div>
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 12px;">
                        <span>Kategori: {{ $question->category->name }}</span>
                        @if($question->assignedLawyer)
                            <span style="margin-left: 16px;">Avukat: {{ $question->assignedLawyer->name }}</span>
                        @endif
                    </div>
                    <div style="color: #6b7280; font-size: 12px;">
                        Sorulma Tarihi: {{ $question->asked_at->format('d.m.Y H:i') }}
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: white; padding: 60px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); text-align: center;">
            <p style="color: #6b7280; font-size: 16px; margin-bottom: 20px;">Henüz soru sormadınız.</p>
            <a href="{{ route('customer.questions.create') }}" class="btn btn-primary">İlk Sorunuzu Sorun</a>
        </div>
    @endif
@endsection

