<?php

namespace App\Models\Tours\Observers;


use App\Models\Tours\TourBooking;
use App\Notifications\Partner\NewTourBookingRequest;
use App\Notifications\User\Tours\TourBookingCanceled;
use App\Notifications\User\Tours\TourBookingConfirmed;
use App\Notifications\User\Tours\TourBookingCreated;
use App\Notifications\User\Tours\TourBookingPayed;
use App\Traits\Utils;

class TourBookingObserver
{
    public function created(TourBooking $tourBooking)
    {
        Utils::sendNotification($tourBooking->customer, new TourBookingCreated($tourBooking));
        Utils::sendNotification($tourBooking->tour->user, new NewTourBookingRequest($tourBooking));
    }

    public function updated(TourBooking $tourBooking)
    {
        // test
        $originalTourBooking = $tourBooking->getRawOriginal();

        $status = isset($originalTourBooking['status']) ?: 'created';
        if ($status !== $tourBooking->status) {
            switch ($tourBooking->status) {
                case('confirmed'):
                    Utils::sendNotification($tourBooking->customer, new TourBookingConfirmed($tourBooking));
                    break;
                case('canceled'):
                    Utils::sendNotification($tourBooking->customer, new TourBookingCanceled($tourBooking));
                    break;
                case('payed'):
                    Utils::sendNotification($tourBooking->customer,
                        new  TourBookingPayed($tourBooking, $tourBooking->tour->partner));
                    break;
            }
        }
    }
}
