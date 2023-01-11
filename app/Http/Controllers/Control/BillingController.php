<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Excursions\ExcursionBooking;
use App\Models\Tours\TourBooking;

class BillingController extends Controller
{
    public function index()
    {
        $excursionBookings = ExcursionBooking::where('status', 'payed')->with(['payments'])->get();
        $tourBookings = TourBooking::where('status', 'payed')->with(['payments'])->get();

        $orders = $tourBookings->concat($excursionBookings)
            ->sortByDesc('created_at')
            ->keyBy('created_at')->slice(0, 100);

        return view('control.billing.index', compact('orders'));
    }

    public function export()
    {
        return (new OrdersExport)->download('orders_billing.xlsx');
    }
}