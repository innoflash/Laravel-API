<?php

namespace Core\Abstracts;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class CoreNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Sets the notification channels.
     *
     * @param $notifiable
     *
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Constructs the email to be sent.
     *
     * @param $notifiable
     *
     * @return MailMessage
     */
    abstract function toMail($notifiable): MailMessage;

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
