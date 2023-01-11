<?php

namespace App\Notifications\Partner;

use App\Models\Excursions\ExcursionBooking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPayment extends Notification
{
    use Queueable;

    protected $booking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ExcursionBooking $booking)
    {
        $this->booking = $booking;
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
    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->subject(trans('mail.excursion_booking.Excursion booking request', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.You have new excursion booking request!', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.Check booking details and confirm availability pls', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.Excursion booking number', [], $notifiable->locale) . ' ' . $this->booking->id)
            ->line(trans('mail.excursion_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->booking->excursion->title))
            ->action(trans('mail.excursion_booking.View', [], $notifiable->locale), route('cabinet:partner:excursions.booking.view', $this->booking->id))
            ->line(trans('mail.Thank you for using our application!', [], $notifiable->locale));
    }
}
