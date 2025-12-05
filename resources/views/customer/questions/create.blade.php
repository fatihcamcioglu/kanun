@extends('customer.layouts.app')

@section('title', 'Soru Sor')

@push('styles')
<style>
    .file-upload-container {
        margin-bottom: 20px;
    }
    .file-upload-label {
        display: block;
        margin-bottom: 8px;
        color: #1f2937;
        font-weight: 500;
    }
    .file-upload-area {
        border: 2px dashed #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        background: #f9fafb;
        transition: all 0.3s;
        cursor: pointer;
        position: relative;
    }
    .file-upload-area:hover {
        border-color: #f59e0b;
        background: #fef3c7;
    }
    .file-upload-area.dragover {
        border-color: #f59e0b;
        background: #fef3c7;
    }
    .file-input {
        display: none;
    }
    .file-upload-icon {
        font-size: 32px;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .file-upload-text {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 4px;
    }
    .file-upload-hint {
        color: #9ca3af;
        font-size: 12px;
    }
    .file-preview-list {
        margin-top: 16px;
        display: grid;
        gap: 12px;
    }
    .file-preview-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        gap: 12px;
    }
    .file-preview-info {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }
    .file-preview-icon {
        font-size: 24px;
        flex-shrink: 0;
    }
    .file-preview-name {
        color: #1f2937;
        font-size: 14px;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .file-preview-size {
        color: #6b7280;
        font-size: 12px;
    }
    .file-remove-btn {
        padding: 6px 12px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: background 0.3s;
    }
    .file-remove-btn:hover {
        background: #dc2626;
    }
    .file-upload-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Soru Sor</h1>
        <p>Avukatlarımıza sorunuzu iletebilirsiniz</p>
    </div>

    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); max-width: 800px;">
        <div style="background: #fef3c7; padding: 12px; border-radius: 8px; margin-bottom: 24px;">
            <div style="margin-bottom: 8px;"><strong>Kalan Soru Hakkınız:</strong> {{ $activeOrder->remaining_question_count }}</div>
            <div><strong>Kalan Ses Hakkınız:</strong> {{ $activeOrder->remaining_voice_count }}</div>
        </div>

        <form method="POST" action="{{ route('customer.questions.store') }}" enctype="multipart/form-data" id="questionForm">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="category_id" style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 500;">Kategori *</label>
                <select name="category_id" id="category_id" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;">
                    <option value="">Kategori Seçin</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="title" style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 500;">Başlık *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px;" placeholder="Sorunuzun kısa başlığı">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 500;">Soru Detayı <span style="color: #6b7280; font-weight: normal;">(Yazılı veya Sesli)</span></label>
                <textarea name="question_body" id="question_body" rows="8" style="width: 100%; padding: 12px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 16px; font-family: inherit;" placeholder="Sorunuzu yazılı olarak açıklayın (veya ses kaydı yapın)">{{ old('question_body') }}</textarea>
                <p style="color: #6b7280; font-size: 12px; margin-top: 4px;">Yazılı soru veya ses kaydından en az birini doldurmalısınız.</p>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; color: #1f2937; font-weight: 500;">Sesli Soru</label>
                <div style="border: 2px dashed #e5e7eb; border-radius: 8px; padding: 20px; text-align: center; background: #f9fafb;">
                    <div id="recorderControls" style="display: flex; flex-direction: column; align-items: center; gap: 12px;">
                        <button type="button" id="startRecordBtn" style="padding: 12px 24px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 500;">
                            🎤 Kayda Başla
                        </button>
                        <div id="recordingStatus" style="display: none; color: #ef4444; font-weight: 500;">
                            <span id="recordingTime">00:00</span> - Kayıt yapılıyor...
                        </div>
                        <div id="recordedAudio" style="display: none; width: 100%;">
                            <audio id="audioPreview" controls style="width: 100%; margin-bottom: 12px;"></audio>
                            <button type="button" id="deleteRecordBtn" style="padding: 8px 16px; background: #ef4444; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 14px;">
                                Sil ve Yeniden Kaydet
                            </button>
                        </div>
                    </div>
                    <input type="file" name="voice_file" id="voice_file" accept="audio/*" style="display: none;">
                    <input type="hidden" name="voice_blob" id="voice_blob">
                </div>
            </div>

            <div class="file-upload-container">
                <label class="file-upload-label">Dosyalar <span style="color: #6b7280; font-weight: normal;">(Word, PDF, Görsel - Maksimum 4 dosya)</span></label>
                <div class="file-upload-grid" id="fileUploadGrid">
                    <div class="file-upload-area" data-file-index="0">
                        <input type="file" name="files[]" class="file-input" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png,.gif,.webp" data-index="0">
                        <div class="file-upload-icon">📎</div>
                        <div class="file-upload-text">Dosya 1</div>
                        <div class="file-upload-hint">Word, PDF veya Görsel</div>
                    </div>
                    <div class="file-upload-area" data-file-index="1">
                        <input type="file" name="files[]" class="file-input" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png,.gif,.webp" data-index="1">
                        <div class="file-upload-icon">📎</div>
                        <div class="file-upload-text">Dosya 2</div>
                        <div class="file-upload-hint">Word, PDF veya Görsel</div>
                    </div>
                    <div class="file-upload-area" data-file-index="2">
                        <input type="file" name="files[]" class="file-input" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png,.gif,.webp" data-index="2">
                        <div class="file-upload-icon">📎</div>
                        <div class="file-upload-text">Dosya 3</div>
                        <div class="file-upload-hint">Word, PDF veya Görsel</div>
                    </div>
                    <div class="file-upload-area" data-file-index="3">
                        <input type="file" name="files[]" class="file-input" accept=".doc,.docx,.pdf,.jpg,.jpeg,.png,.gif,.webp" data-index="3">
                        <div class="file-upload-icon">📎</div>
                        <div class="file-upload-text">Dosya 4</div>
                        <div class="file-upload-hint">Word, PDF veya Görsel</div>
                    </div>
                </div>
                <div id="filePreviewContainer" class="file-preview-list"></div>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary" id="submitBtn">Soruyu Gönder</button>
                <a href="{{ route('customer.questions.index') }}" class="btn" style="background: #e5e7eb; color: #1f2937;">İptal</a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        let mediaRecorder;
        let audioChunks = [];
        let recordingInterval;
        let recordingSeconds = 0;
        let isRecording = false;

        const startRecordBtn = document.getElementById('startRecordBtn');
        const recordingStatus = document.getElementById('recordingStatus');
        const recordingTime = document.getElementById('recordingTime');
        const recordedAudio = document.getElementById('recordedAudio');
        const audioPreview = document.getElementById('audioPreview');
        const deleteRecordBtn = document.getElementById('deleteRecordBtn');
        const voiceFileInput = document.getElementById('voice_file');
        const voiceBlobInput = document.getElementById('voice_blob');
        const questionForm = document.getElementById('questionForm');
        const questionBody = document.getElementById('question_body');

        startRecordBtn.addEventListener('click', async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                
                // Determine best MIME type for MediaRecorder
                let mimeType = 'audio/webm';
                const types = ['audio/webm', 'audio/webm;codecs=opus', 'audio/ogg;codecs=opus', 'audio/mp4'];
                for (let type of types) {
                    if (MediaRecorder.isTypeSupported(type)) {
                        mimeType = type;
                        break;
                    }
                }
                
                mediaRecorder = new MediaRecorder(stream, { mimeType: mimeType });
                audioChunks = [];
                recordingSeconds = 0;

                mediaRecorder.ondataavailable = (event) => {
                    if (event.data.size > 0) {
                        audioChunks.push(event.data);
                    }
                };

                mediaRecorder.onstop = () => {
                    // Use the actual MIME type from MediaRecorder
                    const actualMimeType = mediaRecorder.mimeType || mimeType;
                    const audioBlob = new Blob(audioChunks, { type: actualMimeType });
                    const audioUrl = URL.createObjectURL(audioBlob);
                    audioPreview.src = audioUrl;
                    
                    // Determine file extension based on MIME type
                    let extension = 'webm';
                    let finalMimeType = actualMimeType;
                    
                    if (actualMimeType.includes('ogg') || actualMimeType.includes('opus')) {
                        extension = 'ogg';
                        finalMimeType = 'audio/ogg';
                    } else if (actualMimeType.includes('mp4') || actualMimeType.includes('m4a')) {
                        extension = 'm4a';
                        finalMimeType = 'audio/mp4';
                    } else if (actualMimeType.includes('webm')) {
                        extension = 'webm';
                        finalMimeType = 'audio/webm';
                    } else {
                        // Default to webm
                        extension = 'webm';
                        finalMimeType = 'audio/webm';
                    }
                    
                    // Create a File object for the file input with correct MIME type
                    const file = new File([audioBlob], `voice-recording.${extension}`, { 
                        type: finalMimeType,
                        lastModified: Date.now()
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    voiceFileInput.files = dataTransfer.files;

                    recordedAudio.style.display = 'block';
                    startRecordBtn.style.display = 'none';
                    recordingStatus.style.display = 'none';
                    
                    // Stop all tracks
                    stream.getTracks().forEach(track => track.stop());
                };

                mediaRecorder.start();
                isRecording = true;
                startRecordBtn.textContent = '⏹️ Kaydı Durdur';
                startRecordBtn.style.background = '#6b7280';
                recordingStatus.style.display = 'block';
                
                // Start timer
                recordingInterval = setInterval(() => {
                    recordingSeconds++;
                    const minutes = Math.floor(recordingSeconds / 60);
                    const seconds = recordingSeconds % 60;
                    recordingTime.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                }, 1000);

            } catch (error) {
                alert('Mikrofon erişimi reddedildi. Lütfen tarayıcı ayarlarından mikrofon iznini verin.');
                console.error('Error accessing microphone:', error);
            }
        });

        // Stop recording when button is clicked again
        startRecordBtn.addEventListener('click', function() {
            if (isRecording && mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
                isRecording = false;
                clearInterval(recordingInterval);
                startRecordBtn.textContent = '🎤 Kayda Başla';
                startRecordBtn.style.background = '#ef4444';
            }
        });

        deleteRecordBtn.addEventListener('click', () => {
            audioChunks = [];
            recordedAudio.style.display = 'none';
            startRecordBtn.style.display = 'block';
            audioPreview.src = '';
            voiceBlobInput.value = '';
            voiceFileInput.value = '';
        });

        // Form validation
        questionForm.addEventListener('submit', (e) => {
            const hasText = questionBody.value.trim().length > 0;
            const hasVoice = voiceBlobInput.value.length > 0 || voiceFileInput.files.length > 0;

            if (!hasText && !hasVoice) {
                e.preventDefault();
                alert('Lütfen yazılı soru veya ses kaydı ekleyin.');
                return false;
            }
        });

        // File upload functionality
        const fileInputs = document.querySelectorAll('.file-input');
        const filePreviewContainer = document.getElementById('filePreviewContainer');
        const fileUploadAreas = document.querySelectorAll('.file-upload-area');

        // Helper function to get file icon
        function getFileIcon(fileName) {
            const extension = fileName.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(extension)) {
                return '🖼️';
            } else if (extension === 'pdf') {
                return '📄';
            } else if (['doc', 'docx'].includes(extension)) {
                return '📝';
            }
            return '📎';
        }

        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Update file preview
        function updateFilePreview() {
            filePreviewContainer.innerHTML = '';
            
            fileInputs.forEach((input, index) => {
                if (input.files.length > 0) {
                    const file = input.files[0];
                    const previewItem = document.createElement('div');
                    previewItem.className = 'file-preview-item';
                    previewItem.innerHTML = `
                        <div class="file-preview-info">
                            <span class="file-preview-icon">${getFileIcon(file.name)}</span>
                            <div style="flex: 1; min-width: 0;">
                                <div class="file-preview-name">${file.name}</div>
                                <div class="file-preview-size">${formatFileSize(file.size)}</div>
                            </div>
                        </div>
                        <button type="button" class="file-remove-btn" data-file-index="${index}">Sil</button>
                    `;
                    filePreviewContainer.appendChild(previewItem);
                }
            });
        }

        // Handle file input change
        fileInputs.forEach((input, index) => {
            input.addEventListener('change', function(e) {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    
                    // Validate file type
                    const allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
                    const extension = file.name.split('.').pop().toLowerCase();
                    
                    if (!allowedExtensions.includes(extension)) {
                        alert('Geçersiz dosya türü. Lütfen Word, PDF veya görsel dosyası seçin.');
                        this.value = '';
                        return;
                    }
                    
                    // Check file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Dosya boyutu çok büyük. Maksimum 10MB olabilir.');
                        this.value = '';
                        return;
                    }
                    
                    updateFilePreview();
                } else {
                    updateFilePreview();
                }
            });
        });

        // Handle remove file button clicks
        filePreviewContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('file-remove-btn')) {
                const index = parseInt(e.target.dataset.fileIndex);
                const input = fileInputs[index];
                if (input) {
                    input.value = '';
                    updateFilePreview();
                }
            }
        });

        // Handle drag and drop
        fileUploadAreas.forEach((area, index) => {
            area.addEventListener('click', function() {
                const input = this.querySelector('.file-input');
                input.click();
            });

            area.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            area.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            area.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const input = this.querySelector('.file-input');
                    const file = files[0];
                    
                    // Validate file type
                    const allowedExtensions = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
                    const extension = file.name.split('.').pop().toLowerCase();
                    
                    if (!allowedExtensions.includes(extension)) {
                        alert('Geçersiz dosya türü. Lütfen Word, PDF veya görsel dosyası seçin.');
                        return;
                    }
                    
                    // Check file size (10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('Dosya boyutu çok büyük. Maksimum 10MB olabilir.');
                        return;
                    }
                    
                    // Set file to input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    input.files = dataTransfer.files;
                    
                    // Trigger change event
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });
    </script>
    @endpush
@endsection

