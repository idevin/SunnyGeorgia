<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Controller;
use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        $tourBookings = $user->tourBookings()->latest()->get()->load('accommodationBooking', 'tour', 'tour.translations');
        $excursionBookings = $user->excursionBookings()->latest()->get()->load('excursion', 'excursion.translations');

        $orders = $tourBookings->concat($excursionBookings)->sortByDesc('created_at')->keyBy('created_at');
        return view('cabinet.user.orders', compact('orders', 'user'));
    }

    public function tourBookingView($id)
    {
        $user = \Auth::user();
        $item = $user->tourBookings()->findOrFail($id)->load('accommodationBooking', 'tour', 'tour.translations', 'guests');
        $review = $item->tour->reviews->where('author_id', $user->id)->first();
        return view('cabinet.user.booking_tour_view',
            compact('item', 'user', 'review'));
    }

    public function tourBookingCancel($id)
    {
        $user = \Auth::user();
        $item = $user->tourBookings()->findOrFail($id);
        $item->status = 'canceled';
        $item->save();
        return back()->with(['msg' => 'Booking canceled!']);
    }

    public function excursionBookingView($id)
    {
        $user = \Auth::user();
        $item = $user->excursionBookings()->findOrFail($id)->load('excursion', 'excursion.translations', 'excursion.prices');
        $review = $item->excursion->reviews->where('author_id', $user->id)->first();
        $partner = $item->excursion->partner;
        $currency = currency()->getUserCurrency();
        return view('cabinet.user.booking_excursion_view',
            compact('item', 'user', 'partner', 'review'));
    }

    public function excursionBookingCancel($id)
    {
        $user = \Auth::user();
        $item = $user->excursionBookings()->findOrFail($id);
        $item->status = 'canceled';
        $item->save();
        return back()->with(['msg' => 'Booking canceled!']);
    }

    public function excursionReview($id, Request $request)
    {
        $user = \Auth::user();
        $excursion = Excursion::findOrFail($id);
        $review = $this->makeReview($excursion, $user, $request);
        return response()->json($review);
    }

    protected function makeReview($product, $user, $request)
    {
        //todo отзыв на поездку
        $reviewData = [
            'title' => str_limit($request->input('review'), 30),
            'body' => $request->input('review'),
            'rating' => $request->input('rating'),
        ];
        $review = $product->reviews->where('author_id', $user->id)->first();
        if (!$review) {
            $review = $product->createReview($reviewData, $user);
        } else {
            $review = $product->updateReview($review->id, $reviewData);
        }
        return $review;
    }

    public function tourReview($id, Request $request)
    {
        $user = \Auth::user();
        $tour = Tour::findOrFail($id);
        $review = $this->makeReview($tour, $user, $request);
        return response()->json($review);
    }
}
