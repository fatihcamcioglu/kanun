<?php

namespace App\Notifications;

use App\Models\LegalQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAssignedToLawyer extends Notification
{
    use Queueable;

    public function __construct(public LegalQuestion $question)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $question = $this->question;
        $question->load(['user', 'category']);

        return (new MailMessage)
            ->subject('Yeni Bir Soru Size Atandı - Kanun-i')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('Size yeni bir hukuki soru atanmıştır.')
            ->line('**Soru Başlığı:** ' . $question->title)
            ->line('**Kategori:** ' . $question->category->name)
            ->line('**Müşteri:** ' . $question->user->name)
            ->action('Soruyu Görüntüle', url('/lawyer/assigned-questions/' . $question->id))
            ->line('Soruyu en kısa sürede cevaplamanız beklenmektedir.')
            ->salutation('Saygılarımızla, Kanun-i Ekibi');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'question_id' => $this->question->id,
            'question_title' => $this->question->title,
        ];
    }
}
