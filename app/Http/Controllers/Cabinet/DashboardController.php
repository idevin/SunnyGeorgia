<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Controller;
use App\Models\Tours\Tour;

class DashboardController extends Controller
{

    public function index()
    {
        $user = \Auth::user();

        $tourBookings = $user->tourBookings()->where('status', '<>', 'canceled')->latest()->get()->load('accommodationBooking', 'tour', 'tour.translations');
        $excursionBookings = $user->excursionBookings()->where('status', '<>', 'canceled')->latest()->get()->load('excursion', 'excursion.translations');

        $orders = $tourBookings->concat($excursionBookings)->sortByDesc('created_at')->keyBy('created_at')->slice(0, 2);

        $partnerExcursionBookings = $user->partnerExcursionsBookings()->latest()->limit(20)->get()->load('excursion', 'excursion.translations');
        $partnerTourBookings = $user->partnerTourBookings()->latest()->limit(20)->get()->load('accommodationBooking', 'tour', 'tour.translations');

        $toursForReview = collect();
        if ($user->hasRole('admin')) {
            $toursForReview = Tour::wherePublished(true)->whereReviewed(false)->with('place', 'place.translations')->get();
        }
        return view('cabinet.dashboard', compact('user', 'orders', 'partnerTourBookings', 'partnerExcursionBookings', 'toursForReview'));
    }
}