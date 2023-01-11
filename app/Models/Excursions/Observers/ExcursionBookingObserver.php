<?php

namespace App\Models\Excursions\Observers;


use App\Models\Excursions\ExcursionBooking;
use App\Notifications\Partner\NewExcursionBookingRequest;
use App\Notifications\User\Excursions\ExcursionBookingCanceled;
use App\Notifications\User\Excursions\ExcursionBookingConfirmed;
use App\Notifications\User\Excursions\ExcursionBookingCreated;
use App\Notifications\User\Excursions\ExcursionBookingPayed;
use App\Traits\Utils;

class ExcursionBookingObserver
{

    public function created(ExcursionBooking $booking)
    {
        Utils::sendNotification($booking->customer, new ExcursionBookingCreated($booking));
        Utils::sendNotification($booking->excursion->user, new NewExcursionBookingRequest($booking));
    }

    public function updated(ExcursionBooking $booking)
    {
        // test
        $originalBooking = $booking->getRawOriginal();

        $status = isset($originalBooking['status']) ?: 'created';
        if ($status !== $booking->status) {
            switch ($booking->status) {
                case('confirmed'):
                    Utils::sendNotification($booking->customer, new ExcursionBookingConfirmed($booking));
                    break;
                case('canceled'):
                    Utils::sendNotification($booking->customer, new ExcursionBookingCanceled($booking));
                    break;
                case('payed'):
                    Utils::sendNotification($booking->customer,
                        new ExcursionBookingPayed($booking, $booking->excursion->partner));
                    break;
            }
        }
    }
}
