@php
    use Illuminate\Support\Facades\Storage;
    $record = $record ?? ($getRecord() ?? null);
    $files = $record?->files ?? collect();
@endphp

@if($files->count() > 0)
    <div style="display: grid; gap: 16px; margin-top: 12px;">
        @foreach($files as $file)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0;">
                    <span style="font-size: 32px;">
                        @if($file->isImage())
                            🖼️
                        @elseif($file->isPdf())
                            📄
                        @else
                            📝
                        @endif
                    </span>
                    <div style="flex: 1; min-width: 0;">
                        <div style="color: #1f2937; font-weight: 500; font-size: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-bottom: 4px;">
                            {{ $file->original_name }}
                        </div>
                        <div style="color: #6b7280; font-size: 12px;">
                            {{ $file->file_size_human }} • {{ ucfirst($file->file_type) }}
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    @if($file->isImage())
                        <a href="{{ $file->file_url }}" target="_blank" style="padding: 8px 16px; background: #f59e0b; color: white; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 500;">
                            Görüntüle
                        </a>
                    @elseif($file->isPdf())
                        <a href="{{ $file->file_url }}" target="_blank" style="padding: 8px 16px; background: #f59e0b; color: white; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 500;">
                            Görüntüle
                        </a>
                    @endif
                    <a href="{{ $file->file_url }}" download="{{ $file->original_name }}" style="padding: 8px 16px; background: #3b82f6; color: white; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 500;">
                        İndir
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

