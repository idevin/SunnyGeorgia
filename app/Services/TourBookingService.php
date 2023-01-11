<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 12.03.2018
 * Time: 14:44
 */

namespace App\Services;


use App\Http\Requests\TourBookingRequest;
use App\Models\Tours\Tour;
use App\Models\Tours\TourBooking;
use App\User;
use Carbon\Carbon;
use DB;

class TourBookingService extends BaseBookingService
{

    protected $request;
    protected $customer;


    public function __construct(TourBookingRequest $request, User $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
    }

    public function order()
    {
        $date = Carbon::parse($this->request->input('date_in'));
        //todo check availability
        $tour = Tour::findOrFail($this->request->input('tour_id'));
        $this->setCurrency($tour->currency);

        $available = true;
        $totalAmount = $this->request->input('tour_id', 0);

        if (!$available) {
            $this->error('No available accommodations');
            return false;
        }
        if (!$totalAmount) {
            $this->error('guests are empty');
            return false;
        }

        $booking = new TourBooking;
        $booking->customer_id = $this->customer->id;
        $booking->tour_id = $tour->id;
        $booking->qty_adults = $this->request->input('adults', 0);
        $booking->qty_kids = $this->request->input('kids', 0);
        $booking->date_in = $date->toDateString();
        $booking->currency_code = $this->currency->code;
        $booking->currency_id = $this->currency->id;
        $booking->confirmed = false;
        $booking->sub_total = $this->request->input('cost', 0);
        $booking->hotel = $this->request->input('hotel');
        $booking->accommodation_variant = $this->request->input('accommodation_variant');
        $booking->kids_ages = collect($this->request->input('kids_ages'))
            ->reduce(function ($carry, $item) {
                $delimiter = $carry ? ', ' : '';
                return $carry . $delimiter . $item;
            });


//        $booking->tax = 0;
//        $booking->prepay = 0;
//        $booking->total = 0;
//        $booking->save();

//        todo new AccommodationBooking ненужная сущность? проверить удалить
        if (false) {
//        foreach ($reqAcoms as $acomId => $inputAcom) {
//            if ($inputAcom['adults'] > 0 || $inputAcom['kids'] > 0 || $inputAcom['additional'] > 0) {
//                //shitty code
//                //todo Need todo something better here but i'm too tired
//            } else {
//                continue;
//            }
//            $accomm = $tour->accommodations()->findOrFail($acomId);
//
//            $acomBooking = new AccommodationBooking;
//            $acomBooking->date_in = $date->toDateString();
//            $acomBooking->accommodation_id = $acomId;
//
//            $acomBooking->qty_adults = $inputAcom['adults'] ?: 0;
//            $acomBooking->qty_kids = $inputAcom['kids'] ?: 0;
////            $acomBooking->qty_additional = $inputAcom['additional'] ?: 0;
//
//            $acomBooking->amount_adults = $accomm->price_adult * $inputAcom['adults'];
//            $acomBooking->amount_kids = $accomm->price_kid * $inputAcom['kids'];
//            $acomBooking->amount_additional = $accomm->price_additional * $inputAcom['additional'];
//
//            $booking->accommodationBooking()->save($acomBooking);
//
//            $booking->sub_total += $acomBooking->amount_adults + $acomBooking->amount_kids + $acomBooking->amount_additional;
//            $booking->qty_adults += $acomBooking->qty_adults;
//            $booking->qty_kids += $acomBooking->qty_kids;
//            $booking->qty_additional += $acomBooking->qty_additional;
//        }

//        if ($this->request->has('add_transfer') && $this->request->input('add_transfer') == true) {
//            $booking->transfer_cost = $tour->transfer_price;
//            $booking->sub_total += $booking->transfer_cost;
//        }
//        if ($this->request->has('add_flight') && $this->request->input('add_flight') == true) {
//            $booking->flight_cost = $tour->flight_cost * ($booking->qty_adults + $booking->qty_kids + $booking->qty_additional);
//            $booking->sub_total += $booking->flight_cost;
//        }
//
//
//        if ((integer)$this->request->input('food')) {
//            $totalPersons = $booking->qty_adults + $booking->qty_kids + $booking->qty_additional;
//            $booking->food_option_id = (integer)$this->request->input('food');
//            $food = $tour->foodOptions()->find((integer)$this->request->input('food'));
//            $foodPrice = (float)$food->pivot->price;
//            if ($foodPrice) {
//                $booking->food_option_cost = $foodPrice * $totalPersons;
//                $booking->sub_total += $foodPrice * $totalPersons;
//            }
//        }
        }

        $tourCostService = new TourCostService();
        $tourCostService
            ->price($booking->sub_total)
            ->vatPayer($tour->partner->vat);

        if ($tour->partner->vat && $tour->prepay) {
            $tourCostService->prepayPercent($tour->prepay);
        } else {
            $tourCostService->prepayPercent($tour->commission);
        }

        $booking->tax = $tourCostService->tax();
        $booking->prepay = $tourCostService->prepay();
        $booking->total = $tourCostService->cost();
        $booking->save();

        $this->booking = $booking;
        return $this->booking;
    }
}
