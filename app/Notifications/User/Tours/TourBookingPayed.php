<?php

namespace App\Notifications\User\Tours;

use App\Models\Tours\TourBooking;
use App\Partner;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TourBookingPayed extends Notification
{
    use Queueable;

    protected $tourBooking;
    protected $partner;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TourBooking $tourBooking, Partner $partner)
    {
        $this->tourBooking = $tourBooking;
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
            ->subject(trans('mail.tour_booking.Payment confirmation', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.We have receive your payment', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.Tour booking number', [], $notifiable->locale) . ' ' . $this->tourBooking->id)
            ->line(trans('mail.tour_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->tourBooking->tour->title))
            ->action(trans('mail.tour_booking.View', [], $notifiable->locale), route('cabinet:orders.index'))
            ->line(trans('mail.tour_booking.Free booking cancellation available :days days before tour start date', ['days' => $this->tourBooking->tour->free_cancel_before], $notifiable->locale))
            ->line(trans('mail.tour_booking.Tour operator contacts:', [], $notifiable->locale))
            ->line($this->partner->llc)
            ->line($this->partner->phone)
            ->line($this->partner->email)
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
