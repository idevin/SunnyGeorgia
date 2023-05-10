<?php

namespace App\Http\Controllers\Cabinet\Partner;


use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class ToursBookingController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $tourBooking = $user->partnerTourBookings()->latest()->get();
        return view('cabinet.partner.tours.bookings.index', compact('tourBooking'));
    }

    public function view($id)
    {
        $user = Auth::user();
        $booking = $user->partnerTourBookings()->findOrFail($id);
        $booking->load('customer', 'accommodationBooking', 'accommodationBooking.accommodation', 'accommodationBooking.accommodation.currency',
            'guests', 'tour', 'tour.place', 'tour.partner', 'tour.user');
        $tour = $booking->tour;

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
        return view('cabinet.partner.tours.bookings.view', compact('tour', 'booking'));
    }

    public function update($id, Request $request)
    {
        $user = Auth::user();
        $tourBooking = $user->partnerTourBookings()->find($id);
        if ((float)$tourBooking->total != (float)$request->input('total')) $request->merge(['price_changed' => true]);
        if ((float)$tourBooking->prepay != (float)$request->input('prepay')) $request->merge(['price_changed' => true]);

        $tourBooking->fill($request->all());
        if ($request->has('status')) {
            if ($request->input('status') == 'confirmed' || $request->input('status') == 'canceled')
                $tourBooking->status = $request->input('status');
        }
        $tourBooking->save();
        $success = true;

        if ($request->ajax()) {
            return response()->json(compact('success', 'tourBooking'));
        } else {
            return back()->with(['status' => 'success', 'msg' => 'Updated']);
        }
    }
}