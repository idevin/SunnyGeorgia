<?php

namespace App\Notifications\User\Tours;

use App\Models\Tours\TourBooking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TourBookingConfirmed extends Notification
{
    use Queueable;

    protected $tourBooking;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TourBooking $tourBooking)
    {
        $this->tourBooking = $tourBooking;
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
            ->subject(trans('mail.tour_booking.Tour booking confirmation', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.Your tour was confirmed', [], $notifiable->locale) . '.')
            ->line(trans('mail.tour_booking.Tour booking number', [], $notifiable->locale) . ' ' . $this->tourBooking->id)
            ->line(trans('mail.tour_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->tourBooking->tour->title))
            ->line(trans('mail.tour_booking.Message from operator:', [], $notifiable->locale) . ' ' . strip_tags($this->tourBooking->partner_notes))
            ->line($this->tourBooking->price_changed ? trans('mail.tour_booking.Tour booking price was changed by operator', [], $notifiable->locale) : '')
            // todo проверить роут
            ->action(trans('mail.tour_booking.Go to pay page', [], $notifiable->locale), route('tours.checkout1', ['id' => $this->tourBooking->id]))
            ->line(trans('mail.tour_booking.You can make prepay in during 3 days, but not later then :days day before tour start date, or you booking will be canceled', ['days' => $this->tourBooking->tour->free_cancel_before + 1], $notifiable->locale))
            ->line(trans('mail.tour_booking.Free booking cancellation available :days days before tour start date', ['days' => $this->tourBooking->tour->free_cancel_before], $notifiable->locale))
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
