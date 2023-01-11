<?php

namespace App\Notifications\User\Excursions;

use App\Models\Excursions\ExcursionBooking;
use App\Partner;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExcursionBookingPayed extends Notification
{
    use Queueable;

    protected $booking;
    protected $partner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ExcursionBooking $booking, Partner $partner)
    {
        $this->booking = $booking;
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
    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->subject(trans('mail.excursion_booking.Payment confirmation', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.We have receive your payment', [], $notifiable->locale))
            ->line(trans('mail.excursion_booking.Excursion booking number', [], $notifiable->locale) . ' ' . $this->booking->id)
            ->line(trans('mail.excursion_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->booking->excursion->title))
            ->action(trans('mail.excursion_booking.View', [], $notifiable->locale), route('cabinet:orders.index'))
//            ->line(trans('mail.excursion_booking.Free booking cancellation available :days days before excursion start date', ['days' => $this->booking->excursion->free_cancel_before], $notifiable->locale))
            ->line(trans('mail.excursion_booking.Excursion operator contacts:', [], $notifiable->locale))
            ->line($this->partner->llc)
            ->line($this->partner->phone)
            ->line($this->partner->email)
            ->line(trans('mail.Thank you for using our application!', [], $notifiable->locale));
    }

}
