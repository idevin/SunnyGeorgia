<?php

namespace App\Notifications\User\Excursions;

use App\Models\Excursions\ExcursionBooking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExcursionBookingCreated extends Notification
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
            ->subject(trans('mail.excursion_booking.Excursion booking request sent!', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.After confirmation details and prices we will send you notification', [], $notifiable->locale) . ' '
                . trans('mail.excursion_booking.It can take from 10 min to several hours', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.Excursion booking number', [], $notifiable->locale) . ' ' . $this->booking->id)
            ->line(trans('mail.excursion_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->booking->excursion->title))
            ->line(trans('mail.Thank you for using our application!', [], $notifiable->locale));
    }
}
