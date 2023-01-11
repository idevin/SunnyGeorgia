<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Models\Excursions\ExcursionBooking;
use Illuminate\Http\Request;

class ExcursionsBookingController extends Controller
{

    private $vd = 'control.excursions.bookings';

    public function index()
    {
        $bookings = ExcursionBooking::latest()->with('excursion', 'customer')->paginate(25);
        return view($this->vd . '.index', compact('bookings'));
    }

    public function view($id)
    {
        $booking = ExcursionBooking::findOrFail($id);
        $booking->load('excursion', 'customer', 'excursion.place', 'excursion.place', 'excursion.prices');

        return view($this->vd . '.view', compact('booking'));
    }

    public function update($id, Request $request)
    {
        $booking = ExcursionBooking::findOrFail($id);
        if ((float)$booking->total != (float)$request->input('total')) $request->merge(['price_changed' => true]);
        if ((float)$booking->prepay != (float)$request->input('prepay')) $request->merge(['price_changed' => true]);

        $booking->fill($request->all());
        if ($request->has('status')) {
            if ($request->input('status') == 'confirmed' || $request->input('status') == 'canceled')
                $booking->status = $request->input('status');
        }
        $booking->save();
        $success = true;

        if ($request->ajax()) {
            return response()->json(compact('success', 'booking'));
        } else {
            return back();
        }
    }
}
