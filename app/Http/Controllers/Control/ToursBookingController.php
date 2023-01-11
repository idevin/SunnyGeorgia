<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Models\Tours\TourBooking;
use App\Models\Tours\TourOption;
use App\Models\Tours\TourOptionsGroup;
use Auth;
use Illuminate\Http\Request;
use Storage;

class ToursBookingController extends Controller
{

    public function index()
    {
        $bookings = TourBooking::latest()->with('accommodationBooking', 'tour', 'customer')->paginate(25);
        return view('control.tours.bookings.index', compact('bookings'));
    }

    public function view($id)
    {
        //        todo accommodationBooking, guests === ненужная сущность ? удалить : проверить
        $booking = TourBooking::findOrFail($id)->load(
            'customer',
//            'accommodationBooking',
//            'accommodationBooking.accommodation',
//            'guests',
            'tour', 'tour.place', 'tour.partner', 'tour.user'
        );
        $tour = $booking->tour;

        return view('control.tours.bookings.view', compact('booking', 'tour'));
    }

    public function update($id, Request $request)
    {
        $tourBooking = TourBooking::findOrFail($id);
        $tourBooking->fill($request->all());
        if ($request->has('status')) {
            $tourBooking->status = $request->input('status');
        }
        $tourBooking->save();
        $success = true;

        if ($request->ajax()) {
            return response()->json(compact('success', 'tourBooking'));
        } else {
            return back();
        }
    }
}
