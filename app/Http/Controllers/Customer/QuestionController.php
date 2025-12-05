<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\LegalCategory;
use App\Models\LegalQuestion;
use App\Models\LegalMessage;
use App\Models\CustomerPackageOrder;
use App\Models\QuestionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the user's questions.
     */
    public function index()
    {
        $questions = Auth::user()
            ->legalQuestions()
            ->with(['category', 'assignedLawyer'])
            ->latest()
            ->get();

        return view('customer.questions.index', [
            'questions' => $questions,
        ]);
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        // Check if user has active package with remaining questions or voice quota
        $activeOrder = Auth::user()
            ->orders()
            ->where('status', 'paid')
            ->where(function($query) {
                $query->where('remaining_question_count', '>', 0)
                      ->orWhere('remaining_voice_count', '>', 0);
            })
            ->first();

        if (!$activeOrder) {
            return redirect()->route('customer.packages.index')
                ->with('error', 'Soru sorabilmek için aktif bir paketiniz olmalı.');
        }

        $categories = LegalCategory::where('is_active', true)->get();

        return view('customer.questions.create', [
            'categories' => $categories,
            'activeOrder' => $activeOrder,
        ]);
    }

    /**
     * Store a newly created question.
     */
    public function store(Request $request)
    {
        // Check if user has active package
        $activeOrder = Auth::user()
            ->orders()
            ->where('status', 'paid')
            ->where('remaining_question_count', '>', 0)
            ->first();

        if (!$activeOrder) {
            return redirect()->route('customer.packages.index')
                ->with('error', 'Soru sorabilmek için aktif bir paketiniz olmalı.');
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:legal_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'question_body' => ['nullable', 'string'],
            'voice_file' => ['nullable', 'file', 'max:10240'], // Accept any file, we'll validate manually
            'files' => ['nullable', 'array', 'max:4'],
            'files.*' => ['file', 'max:10240'], // 10MB max per file
        ]);

        $voicePath = null;
        if ($request->hasFile('voice_file')) {
            $file = $request->file('voice_file');
            
            // Validate file is actually an audio file
            $allowedMimes = ['audio/mpeg', 'audio/wav', 'audio/mp3', 'audio/ogg', 'audio/webm', 'audio/x-webm', 'audio/mp4', 'audio/m4a', 'audio/opus', 'audio/x-opus+ogg'];
            $allowedExtensions = ['mp3', 'wav', 'ogg', 'webm', 'm4a', 'mp4', 'mpeg'];
            
            $mimeType = $file->getMimeType();
            $extension = strtolower($file->getClientOriginalExtension());
            
            // Check if it's an audio file by MIME type or extension
            $isAudio = false;
            if (str_starts_with($mimeType, 'audio/') || in_array($mimeType, $allowedMimes)) {
                $isAudio = true;
            }
            if (in_array($extension, $allowedExtensions)) {
                $isAudio = true;
            }
            
            if (!$isAudio) {
                return back()->withErrors([
                    'voice_file' => 'Lütfen geçerli bir ses dosyası yükleyin.',
                ])->withInput();
            }
            
            $voicePath = $file->store('legal-questions/voice', 'public');
            
            // Decrease remaining voice count if voice is used
            if ($activeOrder->remaining_voice_count > 0) {
                $activeOrder->decrement('remaining_voice_count');
            }
        }

        // Either question_body or voice_file must be provided
        if (empty($validated['question_body']) && !$request->hasFile('voice_file')) {
            return back()->withErrors([
                'question_body' => 'Lütfen yazılı soru veya ses kaydı ekleyin.',
            ])->withInput();
        }

        $question = LegalQuestion::create([
            'user_id' => Auth::id(),
            'order_id' => $activeOrder->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'question_body' => $validated['question_body'] ?? null,
            'voice_path' => $voicePath,
            'status' => 'waiting_assignment',
            'asked_at' => now(),
        ]);

        // Decrease remaining question count
        $activeOrder->decrement('remaining_question_count');

        // Handle file uploads (maximum 4 files)
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $order = 0;
            
            foreach ($files as $file) {
                if ($order >= 4) {
                    break; // Maximum 4 files
                }
                
                $mimeType = $file->getMimeType();
                $extension = strtolower($file->getClientOriginalExtension());
                $originalName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                
                // Determine file type
                $fileType = 'document'; // default
                
                // Check if it's an image
                if (str_starts_with($mimeType, 'image/')) {
                    $fileType = 'image';
                }
                // Check if it's a PDF
                elseif ($mimeType === 'application/pdf' || $extension === 'pdf') {
                    $fileType = 'pdf';
                }
                // Check if it's a Word document
                elseif (in_array($mimeType, [
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/vnd.ms-word.document.macroEnabled.12'
                ]) || in_array($extension, ['doc', 'docx'])) {
                    $fileType = 'document';
                }
                
                // Store file
                $filePath = $file->store('legal-questions/files', 'public');
                
                // Create QuestionFile record
                QuestionFile::create([
                    'legal_question_id' => $question->id,
                    'file_path' => $filePath,
                    'original_name' => $originalName,
                    'file_type' => $fileType,
                    'mime_type' => $mimeType,
                    'file_size' => $fileSize,
                    'order' => $order,
                ]);
                
                $order++;
            }
        }

        return redirect()->route('customer.questions.show', $question)
            ->with('success', 'Soru başarıyla gönderildi. Avukat atandıktan sonra cevaplanacaktır.');
    }

    /**
     * Display the specified question.
     */
    public function show(LegalQuestion $question)
    {
        // Ensure the question belongs to the authenticated user
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }

        $question->load(['category', 'assignedLawyer', 'messages.sender', 'files']);
        $messages = $question->messages()->with('sender')->latest()->get();

        return view('customer.questions.show', [
            'question' => $question,
            'messages' => $messages,
        ]);
    }

    /**
     * Store a follow-up message for a question.
     */
    public function storeMessage(Request $request, LegalQuestion $question)
    {
        // Ensure the question belongs to the authenticated user
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'message_body' => ['required', 'string'],
        ]);

        LegalMessage::create([
            'legal_question_id' => $question->id,
            'sender_id' => Auth::id(),
            'sender_role' => 'CUSTOMER',
            'message_body' => $validated['message_body'],
        ]);

        // Update question status if it was answered
        if ($question->status === 'answered') {
            $question->update(['status' => 'waiting_lawyer_answer']);
        }

        // Refresh to get updated relationships
        $question->refresh();

        // Send notification to lawyer - HER MÜŞTERİ MESAJI İÇİN
        if ($question->assignedLawyer && $question->assignedLawyer->email) {
            $question->assignedLawyer->notify(new \App\Notifications\CustomerQuestionToLawyer($question));
        }

        return redirect()->route('customer.questions.show', $question)
            ->with('success', 'Mesajınız gönderildi.');
    }

    /**
     * Rate a message (answer).
     */
    public function rateMessage(Request $request, LegalMessage $message)
    {
        // Ensure the message belongs to a question that belongs to the authenticated user
        if ($message->legalQuestion->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure message is from lawyer
        if ($message->sender_role !== 'LAWYER') {
            return response()->json(['success' => false, 'message' => 'Sadece avukat cevapları oylanabilir.']);
        }

        // Ensure message is not already rated
        if ($message->rating) {
            return response()->json(['success' => false, 'message' => 'Bu cevap zaten oylanmış.']);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $message->update([
            'rating' => $validated['rating'],
            'rated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Puanlama kaydedildi.']);
    }

    /**
     * Rate the lawyer for the entire question.
     */
    public function rateLawyer(Request $request, LegalQuestion $question)
    {
        // Ensure the question belongs to the authenticated user
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure question is answered and all messages are rated
        if ($question->status !== 'answered') {
            return response()->json(['success' => false, 'message' => 'Soru henüz cevaplanmadı.']);
        }

        if (!$question->allMessagesRated()) {
            return response()->json(['success' => false, 'message' => 'Lütfen önce tüm cevapları değerlendirin.']);
        }

        // Ensure question is not already rated
        if ($question->lawyer_rating) {
            return response()->json(['success' => false, 'message' => 'Avukat zaten değerlendirilmiş.']);
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $question->update([
            'lawyer_rating' => $validated['rating'],
            'rated_at' => now(),
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Puanlama kaydedildi ve soru kapatıldı.']);
    }

    /**
     * Close the question (mark as completed).
     */
    public function closeQuestion(Request $request, LegalQuestion $question)
    {
        // Ensure the question belongs to the authenticated user
        if ($question->user_id !== Auth::id()) {
            abort(403);
        }

        // Ensure question is answered
        if ($question->status !== 'answered') {
            return back()->with('error', 'Sadece cevaplanmış sorular kapatılabilir.');
        }

        // Ensure question is not already closed
        if ($question->status === 'closed') {
            return back()->with('error', 'Bu soru zaten kapatılmış.');
        }

        $previousStatus = $question->status;
        
        // Update question status
        $question->status = 'closed';
        $question->closed_at = now();
        $question->save();

        // Log activity (müşteri tarafından kapatıldı)
        // Note: ActivityLogService will use Auth::id() which will be the customer's ID
        \App\Services\ActivityLogService::log(
            action: 'close_question',
            description: "Müşteri tarafından soru tamamlandı: #{$question->id} ({$question->title})",
            model: $question,
            changes: [
                'status' => 'closed',
                'previous_status' => $previousStatus,
                'closed_by' => 'customer',
            ]
        );

        return redirect()->route('customer.questions.show', $question)
            ->with('success', 'Soru başarıyla tamamlandı ve kapatıldı.');
    }
}
