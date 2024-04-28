<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private string $email, private string $token)
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
        return (new MailMessage)
                    ->line(__('auth.verify_email_intro'))
                    ->action(__('auth.verify_email_action'), route('site.auth.verify-email.verify', [
                        'email' => $this->email,
                        'token' => $this->token
                    ]))
                    ->line(__('auth.verify_token_show', ['token' => $this->token]))
                    ->line(__('auth.verify_email_link_plain', [
                        'link' => route('site.auth.verify-email.verify', [
                            'email' => $this->email,
                            'token' => $this->token
                        ])
                    ]));
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
