<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailActivationLinkAndPassword extends Notification
{
    use Queueable;

    protected $token;
    protected $password;

    /**
     * Create a new notification instance.
     *
     * @param $token
     * @param $password
     */
    public function __construct($token, $password)
    {
        $this->token = $token;
        $this->password = $password;
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
            ->subject('Activation mail')
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->action('Activate email', route('user.activate', ['token' => $this->token]))
            ->line('Your password is: ' . $this->password)
            ->line('Pls change your password as soon as possible.');
    }
}
