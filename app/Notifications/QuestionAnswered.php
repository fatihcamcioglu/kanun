<?php

namespace App\Notifications;

use App\Models\LegalQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuestionAnswered extends Notification
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
        $question->load(['assignedLawyer', 'category']);

        return (new MailMessage)
            ->subject('Sorunuza Cevap Verildi - Kanun-i')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('"' . $question->title . '" başlıklı sorunuza cevap verilmiştir.')
            ->line('**Avukat:** ' . $question->assignedLawyer->name)
            ->line('**Kategori:** ' . $question->category->name)
            ->action('Cevabı Görüntüle', url('/customer/questions/' . $question->id))
            ->line('Sorunuzla ilgili ek bir sorunuz varsa soru detay sayfasından mesaj gönderebilirsiniz.')
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
