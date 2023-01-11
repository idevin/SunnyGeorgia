<?php

namespace App\Notifications\User\Excursions;

use App\Models\Excursions\ExcursionBooking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExcursionBookingConfirmed extends Notification
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
     * @return MailMessage
     */
    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->subject(trans('mail.excursion_booking.Excursion booking confirmation', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.Your excursion was confirmed', [], $notifiable->locale) . '.')
            ->line(trans('mail.excursion_booking.Excursion booking number', [], $notifiable->locale) . ' ' . $this->booking->id)
            ->line(trans('mail.excursion_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->booking->excursion->title))
            ->line(trans('mail.excursion_booking.Message from operator:', [], $notifiable->locale) . ' ' . strip_tags($this->booking->partner_notes))
            ->line($this->booking->price_changed ? trans('mail.excursion_booking.Excursion booking price was changed by operator', [], $notifiable->locale) : '')
            ->action(trans('mail.excursion_booking.Go to pay page', [], $notifiable->locale), route('excursions.checkout1', ['locale' => $notifiable->locale, 'id' => $this->booking->id, 'token' => encrypt($notifiable->id, false)]))
            ->line(trans('mail.Thank you for using our application!', [], $notifiable->locale));
    }
}
