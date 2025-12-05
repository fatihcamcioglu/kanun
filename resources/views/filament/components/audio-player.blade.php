@php
    use Illuminate\Support\Facades\Storage;
    $record = $record ?? ($getRecord() ?? null);
    $voicePath = $record?->voice_path ?? null;
    $voiceUrl = $voicePath ? Storage::disk('public')->url($voicePath) : null;
@endphp

@if($voicePath && $voiceUrl)
    <div style="margin-top: 12px; padding: 16px; background: #f9fafb; border-radius: 8px;">
        <div style="margin-bottom: 8px; font-weight: 500; color: #1f2937;">Sesli Soru:</div>
        <audio controls style="width: 100%; max-width: 600px;">
            <source src="{{ $voiceUrl }}" type="audio/webm">
            <source src="{{ $voiceUrl }}" type="audio/ogg">
            <source src="{{ $voiceUrl }}" type="audio/mpeg">
            <source src="{{ $voiceUrl }}" type="audio/mp4">
            Tarayıcınız ses dosyasını desteklemiyor.
        </audio>
        <p style="margin-top: 8px; font-size: 12px; color: #6b7280;">
            <a href="{{ $voiceUrl }}" target="_blank" style="color: #3b82f6; text-decoration: none;">
                📥 Ses dosyasını indir
            </a>
        </p>
    </div>
@endif

