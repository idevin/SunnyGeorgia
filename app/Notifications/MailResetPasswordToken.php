<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MailResetPasswordToken extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('mail.Reset password', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.You are receiving this email because we received a password reset request for your account.', [], $notifiable->locale))
            ->action(trans('mail.Reset password', [], $notifiable->locale), route('password.reset', ['email' => $notifiable->email, 'token' => $this->token]))
            ->line(trans('mail.If you did not request a password reset, no further action is required.', [], $notifiable->locale))
            ->line(trans('mail.Thank you for using our application!', [], $notifiable->locale));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
