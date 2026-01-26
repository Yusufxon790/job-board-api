<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $application)
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
        $url = config('app.url') . '/api/applications/' . $this->application->id;
        return (new MailMessage)
            ->subject("Yangi ariza kelib tushdi!")
            ->greeting('Salom, ' . $notifiable->name)
            ->line('Sizning "' . $this->application->job->title . '" vakansiyangizga yangi nomzoddan ariza tushdi.')
            ->line('Nomzod: ' . $this->application->user->name)
            ->action('Arizani ko\'rish', $url)
            ->line('Ishlaringizda rivoj tilaymiz!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
