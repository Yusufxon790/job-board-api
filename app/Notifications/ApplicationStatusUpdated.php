<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdated extends Notification
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->application->status === 'accepted' ? 'qabul qilindi' : 'rad etildi';
        $url = config('app.url') . '/api/applications';

        return (new MailMessage)
        ->subject('Ariza holati o\'zgardi')
        ->line('Sizning "' . $this->application->job->title . '" vakansiyasi uchun yuborgan arizangiz ' . $statusText . '.')
        ->action('Batafsil ko\'rish', $url)
        ->line('Bizning platformadan foydalanganingiz uchun rahmat!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        'application_id' => $this->application->id,
        'job_title' => $this->application->job->title,
        'status' => $this->application->status,
        'message' => 'Sizning arizangiz holati ' . $this->application->status . ' ga o\'zgardi.',
        ];
    }
}
