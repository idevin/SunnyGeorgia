<?php

namespace App\Notifications\User\Tours;

use App\Models\Tours\TourBooking;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TourBookingCreated extends Notification
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
            ->subject(trans('mail.tour_booking.Tour booking request sent!', [], $notifiable->locale))
            ->greeting(trans('mail.Hello!', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.After confirmation details and prices we will send you notification', [], $notifiable->locale) . ' '
                . trans('mail.tour_booking.It can take from 10 min to several hours', [], $notifiable->locale))
            ->line(trans('mail.tour_booking.Tour booking number', [], $notifiable->locale) . ' ' . $this->tourBooking->id)
            ->line(trans('mail.tour_booking.Title', [], $notifiable->locale) . ' ' . strip_tags($this->tourBooking->tour->title))
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
