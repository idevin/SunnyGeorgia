<?php

namespace App\Exports;

use App\Models\Excursions\ExcursionBooking;
use App\Models\Tours\TourBooking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class OrdersExport implements FromView
{
    use Exportable;

    public function view(): View
    {
        $excursionBookings = ExcursionBooking::where('status', 'payed')->with(['payments'])->get();
        $tourBookings = TourBooking::where('status', 'payed')->with(['payments'])->get();

        $orders = $tourBookings->concat($excursionBookings)
            ->sortByDesc('created_at')
            ->keyBy('created_at');

        return view('control.billing.table', compact('orders'));
    }


}
