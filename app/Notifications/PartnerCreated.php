<?php

namespace App\Notifications;

use App\Partner;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnerCreated extends Notification
{
    use Queueable;


    protected $partner;

    /**
     * Create a new notification instance.
     *
     * @param Partner $partner
     */
    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
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
            ->subject('New partner registered')
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line('User #' . $this->partner->id . ' become a partner!')
            ->line($this->partner->email);
    }
}