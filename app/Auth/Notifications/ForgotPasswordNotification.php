<?php

namespace App\Auth\Notifications;

use Core\Abstracts\CoreNotification;
use Illuminate\Notifications\Messages\MailMessage;

class ForgotPasswordNotification extends CoreNotification
{
    function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password reset!')
            ->greeting('Hi ' . $notifiable->name)
            ->line('You are receiving this email because you have forgotten your current password.')
            ->line('Follow the link below to reset the password.')
            ->action('Reset Password.', $notifiable->generateLoginUrl())
            ->line('Thank you for using our application!');
    }
}
