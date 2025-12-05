@php
    $record = $record ?? ($getRecord() ?? null);
@endphp

@if($record)
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
        <div>
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Müşteri</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px;">{{ $record->user?->name ?? '-' }}</div>
        </div>
        
        <div>
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Kategori</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px;">{{ $record->category?->name ?? '-' }}</div>
        </div>
        
        <div style="grid-column: span 2;">
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Başlık</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px; font-weight: 600;">{{ $record->title ?? '-' }}</div>
        </div>
        
        <div style="grid-column: span 2;">
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Soru İçeriği</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px; white-space: pre-wrap; line-height: 1.6;">{{ $record->question_body ?? '-' }}</div>
        </div>
        
        <div>
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Durum</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px;">
                @php
                    $statusText = match($record->status) {
                        'waiting_assignment' => 'Atama Bekliyor',
                        'waiting_lawyer_answer' => 'Avukat Cevabı Bekliyor',
                        'answered' => 'Cevaplandı',
                        'closed' => 'Kapatıldı',
                        default => $record->status ?? '-',
                    };
                    $statusColor = match($record->status) {
                        'waiting_assignment' => '#f59e0b',
                        'waiting_lawyer_answer' => '#3b82f6',
                        'answered' => '#10b981',
                        'closed' => '#6b7280',
                        default => '#6b7280',
                    };
                @endphp
                <span style="display: inline-block; padding: 4px 12px; background: {{ $statusColor }}20; color: {{ $statusColor }}; border-radius: 6px; font-weight: 500; font-size: 12px;">
                    {{ $statusText }}
                </span>
            </div>
        </div>
        
        <div>
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Atanan Avukat</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px;">{{ $record->assignedLawyer?->name ?? 'Atanmadı' }}</div>
        </div>
        
        <div>
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Sorulma Tarihi</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px;">
                {{ $record->asked_at ? $record->asked_at->format('d.m.Y H:i') : '-' }}
            </div>
        </div>
        
        <div>
            <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px; font-weight: 500;">Cevaplanma Tarihi</div>
            <div style="font-size: 14px; color: #1f2937; margin-bottom: 16px;">
                {{ $record->answered_at ? $record->answered_at->format('d.m.Y H:i') : 'Henüz cevaplanmadı' }}
            </div>
        </div>
    </div>
@endif


