<?php

namespace App\Notifications\Partner;

use App\Models\Tours\TourBooking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTourBookingRequest extends Notification
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
            ->subject(trans('mail.tour_booking.Tour booking request', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.You have new tour booking request!', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.Check booking details and confirm availability pls', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.Tour booking number', [], $notifiable->locale) . ' ' . $this->tourBooking->id)
            ->line(trans('mail.tour_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->tourBooking->tour->title))
            ->action(trans('mail.tour_booking.View', [], $notifiable->locale), route('cabinet:partner:tours.booking.view', $this->tourBooking->id))
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
