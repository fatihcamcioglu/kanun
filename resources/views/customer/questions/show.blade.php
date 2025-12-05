@extends('customer.layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', $question->title)

@section('content')
    <div class="page-header">
        <h1>{{ $question->title }}</h1>
        <p>
            Kategori: {{ $question->category->name }}
            @if($question->assignedLawyer)
                | Avukat: {{ $question->assignedLawyer->name }}
            @endif
        </p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px;">
        <div>
            <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h2 style="color: #1f2937; font-size: 18px; font-weight: 600;">Soru Detayı</h2>
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
                @if($question->question_body)
                    <div style="color: #1f2937; white-space: pre-wrap; line-height: 1.6; margin-bottom: 16px;">{{ $question->question_body }}</div>
                @endif
                @if($question->voice_path)
                    <div style="margin-bottom: 16px;">
                        <strong style="color: #1f2937; display: block; margin-bottom: 8px;">Sesli Soru:</strong>
                        <audio controls style="width: 100%;">
                            <source src="{{ Storage::url($question->voice_path) }}" type="audio/webm">
                            <source src="{{ Storage::url($question->voice_path) }}" type="audio/mpeg">
                            Tarayıcınız ses oynatmayı desteklemiyor.
                        </audio>
                    </div>
                @endif
                @if($question->files && $question->files->count() > 0)
                    <div style="margin-top: 16px; margin-bottom: 16px;">
                        <strong style="color: #1f2937; display: block; margin-bottom: 12px;">Eklenen Dosyalar:</strong>
                        <div style="display: grid; gap: 12px;">
                            @foreach($question->files as $file)
                                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; gap: 12px;">
                                    <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0;">
                                        <span style="font-size: 24px;">
                                            @if($file->isImage())
                                                🖼️
                                            @elseif($file->isPdf())
                                                📄
                                            @else
                                                📝
                                            @endif
                                        </span>
                                        <div style="flex: 1; min-width: 0;">
                                            <div style="color: #1f2937; font-weight: 500; font-size: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $file->original_name }}</div>
                                            <div style="color: #6b7280; font-size: 12px;">{{ $file->file_size_human }}</div>
                                        </div>
                                    </div>
                                    <div style="display: flex; gap: 8px;">
                                        @if($file->isImage())
                                            <button type="button" onclick="viewImage('{{ $file->file_url }}', '{{ $file->original_name }}')" style="padding: 6px 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 500;">Görüntüle</button>
                                        @elseif($file->isPdf())
                                            <button type="button" onclick="viewPdf('{{ $file->file_url }}', '{{ $file->original_name }}')" style="padding: 6px 12px; background: #f59e0b; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 500;">Görüntüle</button>
                                        @endif
                                        <a href="{{ $file->file_url }}" download="{{ $file->original_name }}" style="padding: 6px 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 500; text-decoration: none;">İndir</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div style="color: #6b7280; font-size: 12px; margin-top: 16px;">
                    Sorulma Tarihi: {{ $question->asked_at->format('d.m.Y H:i') }}
                </div>
            </div>

            <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #1f2937; font-size: 18px; font-weight: 600; margin-bottom: 20px;">Mesajlar</h2>
                
                <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                    @foreach($messages as $message)
                        <div style="padding: 16px; background: {{ $message->sender_role === 'CUSTOMER' ? '#f3f4f6' : '#fef3c7' }}; border-radius: 8px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <strong style="color: #1f2937;">{{ $message->sender->name }}</strong>
                                <span style="color: #6b7280; font-size: 12px;">{{ $message->created_at->format('d.m.Y H:i') }}</span>
                            </div>
                            <div style="color: #1f2937; white-space: pre-wrap;">{{ $message->message_body }}</div>
                            
                            @if($message->sender_role === 'LAWYER')
                                <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #e5e7eb;">
                                    @if($message->rating)
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="color: #6b7280; font-size: 14px;">Verdiğiniz Puan:</span>
                                            <div class="rating-display" data-rating="{{ $message->rating }}">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="star {{ $i <= $message->rating ? 'filled' : '' }}" style="font-size: 20px; color: {{ $i <= $message->rating ? '#f59e0b' : '#d1d5db' }};">★</span>
                                                @endfor
                                                <span style="color: #6b7280; font-size: 14px; margin-left: 8px;">({{ $message->rating }}/5)</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="rating-container" data-message-id="{{ $message->id }}">
                                            <span style="color: #6b7280; font-size: 14px; display: block; margin-bottom: 8px;">Bu cevabı değerlendirin:</span>
                                            <div class="star-rating" style="display: flex; gap: 4px;">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" class="star-btn" data-rating="{{ $i }}" style="background: none; border: none; font-size: 24px; color: #d1d5db; cursor: pointer; padding: 0; transition: color 0.2s;" onmouseover="this.style.color='#f59e0b'" onmouseout="if(!this.classList.contains('selected')) this.style.color='#d1d5db'">★</button>
                                                @endfor
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($question->status === 'answered' && !$question->isClosed() && $question->allMessagesRated() && !$question->isRated())
                    <div style="background: #fef3c7; padding: 16px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #f59e0b;">
                        <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin-bottom: 12px;">Avukatı Genel Olarak Değerlendirin</h3>
                        <p style="color: #6b7280; font-size: 14px; margin-bottom: 12px;">Tüm cevapları değerlendirdiniz. Şimdi avukatı genel olarak değerlendirin:</p>
                        <div class="lawyer-rating-container" data-question-id="{{ $question->id }}" style="margin-bottom: 12px;">
                            <div class="star-rating" style="display: flex; gap: 4px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" class="lawyer-star-btn" data-rating="{{ $i }}" style="background: none; border: none; font-size: 28px; color: #d1d5db; cursor: pointer; padding: 0; transition: color 0.2s;" onmouseover="this.style.color='#f59e0b'" onmouseout="if(!this.classList.contains('selected')) this.style.color='#d1d5db'">★</button>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endif

                @if($question->lawyer_rating)
                    <div style="background: #d1fae5; padding: 16px; border-radius: 8px; margin-bottom: 24px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #065f46; font-size: 14px; font-weight: 600;">Genel Avukat Puanınız:</span>
                            <div class="rating-display">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $question->lawyer_rating ? 'filled' : '' }}" style="font-size: 20px; color: {{ $i <= $question->lawyer_rating ? '#f59e0b' : '#d1d5db' }};">★</span>
                                @endfor
                                <span style="color: #065f46; font-size: 14px; margin-left: 8px;">({{ $question->lawyer_rating }}/5)</span>
                            </div>
                        </div>
                    </div>
                @endif

                @if($question->status === 'answered' && !$question->isClosed())
                    <div style="background: #eff6ff; padding: 20px; border-radius: 8px; margin-bottom: 24px; border-left: 4px solid #3b82f6;">
                        <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin-bottom: 12px;">Soru Tamamlandı mı?</h3>
                        <p style="color: #6b7280; font-size: 14px; margin-bottom: 16px;">
                            Sorunuza cevap alındı. İşlemi tamamlamak için "Soru Tamamlandı" butonuna tıklayarak soruyu kapatabilirsiniz.
                        </p>
                        <form method="POST" action="{{ route('customer.questions.close', $question) }}" onsubmit="return confirm('Soruyu tamamlandı olarak işaretleyip kapatmak istediğinize emin misiniz?')">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="background: #3b82f6; padding: 10px 24px; font-weight: 500;">
                                ✓ Soru Tamamlandı
                            </button>
                        </form>
                    </div>
                @endif

                @if($question->status !== 'closed')
                    <form method="POST" action="{{ route('customer.questions.messages.store', $question) }}">
                        @csrf
                        <div style="margin-bottom: 12px;">
                            <textarea name="message_body" rows="4" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 14px; font-family: inherit;" placeholder="Mesajınızı yazın..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Mesaj Gönder</button>
                    </form>
                @endif
            </div>
        </div>

        <div>
            <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin-bottom: 16px;">Soru Bilgileri</h3>
                <div style="color: #6b7280; font-size: 14px; margin-bottom: 12px;">
                    <strong>Kategori:</strong><br>
                    {{ $question->category->name }}
                </div>
                @if($question->assignedLawyer)
                    <div style="color: #6b7280; font-size: 14px; margin-bottom: 12px;">
                        <strong>Atanan Avukat:</strong><br>
                        {{ $question->assignedLawyer->name }}
                    </div>
                @endif
                <div style="color: #6b7280; font-size: 14px;">
                    <strong>Sorulma Tarihi:</strong><br>
                    {{ $question->asked_at->format('d.m.Y H:i') }}
                </div>
            </div>
        </div>
    </div>

<!-- File Viewer Modal -->
<div id="fileViewerModal" class="file-viewer-modal">
    <div class="file-viewer-content">
        <div class="file-viewer-header">
            <div class="file-viewer-title" id="fileViewerTitle"></div>
            <button type="button" class="file-viewer-close" onclick="closeFileViewer()">Kapat</button>
        </div>
        <div class="file-viewer-body" id="fileViewerBody">            </div>
        </div>
    </div>

    <!-- File Viewer Modal -->
    <div id="fileViewerModal" class="file-viewer-modal">
        <div class="file-viewer-content">
            <div class="file-viewer-header">
                <div class="file-viewer-title" id="fileViewerTitle"></div>
                <button type="button" class="file-viewer-close" onclick="closeFileViewer()">Kapat</button>
            </div>
            <div class="file-viewer-body" id="fileViewerBody"></div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .file-viewer-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        overflow: auto;
    }
    .file-viewer-modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .file-viewer-content {
        background-color: white;
        margin: auto;
        padding: 20px;
        border-radius: 12px;
        max-width: 90%;
        max-height: 90%;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    .file-viewer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .file-viewer-title {
        color: #1f2937;
        font-size: 18px;
        font-weight: 600;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        flex: 1;
        margin-right: 16px;
    }
    .file-viewer-close {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        transition: background 0.3s;
    }
    .file-viewer-close:hover {
        background: #dc2626;
    }
    .file-viewer-body {
        max-width: 100%;
        max-height: calc(90vh - 100px);
        overflow: auto;
    }
    .file-viewer-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }
    .file-viewer-body iframe {
        width: 100%;
        min-height: 600px;
        border: none;
        border-radius: 8px;
    }
</style>
@endpush

@push('scripts')
<script>
function viewImage(url, name) {
    const modal = document.getElementById('fileViewerModal');
    const modalTitle = document.getElementById('fileViewerTitle');
    const modalBody = document.getElementById('fileViewerBody');
    
    modalTitle.textContent = name;
    modalBody.innerHTML = `<img src="${url}" alt="${name}" style="max-width: 100%; height: auto;">`;
    modal.classList.add('active');
}

function viewPdf(url, name) {
    const modal = document.getElementById('fileViewerModal');
    const modalTitle = document.getElementById('fileViewerTitle');
    const modalBody = document.getElementById('fileViewerBody');
    
    modalTitle.textContent = name;
    modalBody.innerHTML = `<iframe src="${url}" style="width: 100%; min-height: 600px; border: none;"></iframe>`;
    modal.classList.add('active');
}

function closeFileViewer() {
    const modal = document.getElementById('fileViewerModal');
    modal.classList.remove('active');
}

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('fileViewerModal');
    if (event.target === modal) {
        closeFileViewer();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeFileViewer();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Cevap oylama sistemi
    document.querySelectorAll('.star-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            const messageId = this.closest('.rating-container').dataset.messageId;
            
            // Tüm yıldızları seçili yap
            const container = this.closest('.rating-container');
            container.querySelectorAll('.star-btn').forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('selected');
                    star.style.color = '#f59e0b';
                } else {
                    star.classList.remove('selected');
                    star.style.color = '#d1d5db';
                }
            });

            // AJAX ile oy gönder
            fetch(`/customer/questions/messages/${messageId}/rate`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ rating: rating })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Puanlama kaydedilirken bir hata oluştu.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Puanlama kaydedilirken bir hata oluştu.');
            });
        });
    });

    // Avukat genel oylama sistemi
    document.querySelectorAll('.lawyer-star-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            const questionId = this.closest('.lawyer-rating-container').dataset.questionId;
            
            // Tüm yıldızları seçili yap
            const container = this.closest('.lawyer-rating-container');
            container.querySelectorAll('.lawyer-star-btn').forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('selected');
                    star.style.color = '#f59e0b';
                } else {
                    star.classList.remove('selected');
                    star.style.color = '#d1d5db';
                }
            });

            // AJAX ile oy gönder
            fetch(`/customer/questions/${questionId}/rate-lawyer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ rating: rating })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Puanlama kaydedilirken bir hata oluştu.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Puanlama kaydedilirken bir hata oluştu.');
            });
        });
    });
});
</script>
@endpush
