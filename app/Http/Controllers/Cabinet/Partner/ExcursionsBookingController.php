<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Cabinet\Partner;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ExcursionsBookingController extends Controller
{
    private $vd = 'cabinet.partner.excursions.bookings';

    public function index()
    {
        $user = Auth::user();
        $bookings = $user->partnerExcursionsBookings()->latest()->get();
        return view($this->vd . '.index', compact('bookings'));
    }

    public function view($id)
    {
        $user = Auth::user();
        $booking = $user->partnerExcursionsBookings()->findOrFail($id);
        $booking->load('excursion', 'customer', 'excursion.place', 'excursion.place', 'excursion.prices');

//        $booking->excursion->prices = $booking->excursion->prices->keyBy("id");


        //hiding customer data from partner until payed
        if ($booking->status !== 'payed') {

            unset($booking->customer);
//            unset($booking->customer->first_name);
//            unset($booking->customer->last_name);
//            unset($booking->customer->email);
//            unset($booking->customer->mobile_number);
//            $booking->customer->email = '-';
//            $booking->customer->mobile_number = '-';
        }
        return view($this->vd . '.view', compact('booking'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $booking = $user->partnerExcursionsBookings()->findOrFail($id);
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