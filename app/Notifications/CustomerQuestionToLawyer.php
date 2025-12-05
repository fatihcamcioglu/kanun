<?php

namespace App\Notifications;

use App\Models\LegalQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerQuestionToLawyer extends Notification
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
            ->subject('Sizin Cevapladığınız Soruya Müşteri Soru Sordu - Kanun-i')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('"' . $question->title . '" başlıklı, sizin cevapladığınız soruya müşteri yeni bir soru sormuştur.')
            ->line('**Müşteri:** ' . $question->user->name)
            ->line('**Kategori:** ' . $question->category->name)
            ->action('Soruyu Görüntüle', url('/lawyer/assigned-questions/' . $question->id))
            ->line('Lütfen müşterinin sorusunu en kısa sürede cevaplayınız.')
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

