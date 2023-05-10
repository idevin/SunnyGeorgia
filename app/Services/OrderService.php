<?php
/**
 * Created by PhpStorm.

 * Date: 07.09.2018
 * Time: 20:00
 */

namespace App\Services;


use App\Order;
use App\User;
use Illuminate\Http\Request;

class OrderService
{

    public static function make(Request $request, User $customer)
    {
        $requestClass = get_class($request);

        $bs = $booking = null;

        switch ($requestClass) {
            case \App\Http\Requests\TourBookingRequest::class:
                $bs = new TourBookingService($request, $customer);
                $booking = $bs->order();
                break;
            case \App\Http\Requests\ExcursionBookingRequest::class:
                $bs = new ExcursionBookingService($request, $customer);
                $booking = $bs->order();
                break;
        }

        if ($booking) {
            $order = new Order();
            $order->customer_id = $customer->id;
            $booking->order()->save($order);
        }
        return $bs;
    }
}