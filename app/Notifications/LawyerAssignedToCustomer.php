<?php

namespace App\Notifications;

use App\Models\LegalQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LawyerAssignedToCustomer extends Notification
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
            ->subject('Sorunuza Avukat Atandı - Kanun-i')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('"' . $question->title . '" başlıklı sorunuza bir avukat atanmıştır.')
            ->line('**Atanan Avukat:** ' . $question->assignedLawyer->name)
            ->line('**Kategori:** ' . $question->category->name)
            ->action('Soruyu Görüntüle', url('/customer/questions/' . $question->id))
            ->line('Avukatımız sorunuzu en kısa sürede cevaplayacaktır.')
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
            'lawyer_id' => $this->question->assigned_lawyer_id,
        ];
    }
}
