<?php

use App\BankPayment;
use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use App\Services\ExcursionCostService;
use App\Services\TourCostService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrdersFakeSeeder extends Seeder
{
    protected $tours;
    protected $excursions;
    protected $users;
    protected $currencies;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->tours = \App\Models\Tours\Tour::all();
        $this->excursions = \App\Models\Excursions\Excursion::all();
        $this->users = \App\User::all();
        $this->currencies = \App\Currency::all();

        $products = $this->tours->concat($this->excursions);
        $count = $products->count();
        for ($i = 0; $i < $count; $i++) {
            $item = $products->random();

            if ($item->published && $item->reviewed) {
                $booking = $this->book($item);
            }
        }

    }

    protected function book($item)
    {
        if ($item instanceof \App\Models\Tours\Tour) {
            return $this->bookTour($item);
        } elseif ($item instanceof \App\Models\Excursions\Excursion) {
            return $this->bookExcursion($item);
        }
        return false;
    }

    protected function bookTour(Tour $tour)
    {
        if(!$tour->partner) return false;
        $availabilities = $tour->availability()->get();
        if ($availabilities->isEmpty()) return false;
        $availability = $availabilities->random();
        $booking = new \App\Models\Tours\TourBooking();
        $customer = $this->randomUser();
        $currency = $this->randomCurrency();

        $booking->customer_id = $customer->id;
        $booking->tour_id = $tour->id;
//            $booking->qty_adults = 0;
//            $booking->qty_kids = 0;
//            $booking->qty_additional = 0;
        $booking->date_in = $availability->date;


        //estimating date out
        if ($tour->days < $tour->nights) {
            $totalDays = $tour->days + 2;
        } elseif ($tour->days == $tour->nights) {
            $totalDays = $tour->days + 1;
        } elseif ($tour->days > $tour->nights) {
            $totalDays = $tour->days;
        }

        $booking->date_out = (new Carbon($booking->date_in))->addDays($totalDays - 1);

        $booking->currency_code = $currency->code;
        $booking->currency_id = $currency->id;
        $booking->confirmed = false;
        $booking->notes = '';
        $booking->sub_total = rand(1,770) * 10;
        $booking->tax = 0;
        $booking->prepay = 0;
        $booking->total = 0;
        $booking->add_flight = $tour->flight_included;
        $booking->add_transfer = $tour->transfer_included;
        $booking->save();

        $tourCostService = new TourCostService();
        $tourCostService
            ->price($booking->sub_total)
            ->vatPayer(false);

        $booking->tax = $tourCostService->tax();
        $booking->prepay = $tourCostService->prepay();
        $booking->total = $tourCostService->cost();
        $booking->save();

        $this->fakePayment($customer, $booking);

        echo "+ tour: $booking->id\r\n";
        return $booking;
    }

    protected function bookExcursion(Excursion $excursion)
    {
        $booking = new \App\Models\Excursions\ExcursionBooking();

        $availabilities = $excursion->availabilities()->get();
        if ($availabilities->count() == 0) return false;
        $availability = $availabilities->random();

        $booking->status = 'created';
        $booking->excursion_id = $excursion->id;
        $booking->excursion_availability_id = $availability->id;

        $customer = $this->randomUser();
        $booking->customer_id = $customer->id;

        $booking->date_time_in = $availability->date . ' ' . $availability->time;
        $booking->date_in = $availability->date;
        $booking->time_in = $availability->time;

        $booking->qty_adults = rand(1, 4);
        $booking->qty_kids = rand(0, 2);
        $booking->customer_notes = '';

        //checking available places
        if ($booking->qty_adults + $booking->qty_kids > $availability->amount) {
            return false;
        }
        $currency = $this->randomCurrency();


        if ($excursion->price_excursion) {
            $booking->sub_total = currency($excursion->price_excursion, $excursion->currency->code, $currency->code, false);
        } else {
            $localPriceKid = currency((float)$excursion->price_kid, $excursion->currency->code, $currency->code, false);
            $localPriceAdult = currency((float)$excursion->price_adult, $excursion->currency->code, $currency->code, false);
            $booking->sub_total = round($localPriceKid, 2) * $booking->qty_kids + round($localPriceAdult, 2) * $booking->qty_adults;
        }

        $costService = new ExcursionCostService();
        $costService->price($booking->sub_total);

        $booking->currency_code = $currency->code;
        $booking->currency_id = $currency->id;

        $booking->tax = $costService->tax();
        $booking->prepay = $costService->prepay();
        $booking->total = $costService->cost();
        $booking->save();

        $this->fakePayment($customer, $booking);

        echo "+ excursion: $booking->id\r\n";
        return $booking;
    }

    protected function randomUser()
    {
        return $this->users->random();
    }

    protected function randomCurrency()
    {
        return $this->currencies->random();
    }

    protected function fakePayment(\App\User $user, $booking)
    {
        $bankPayment = new BankPayment();
        $bankPayment->system = 'GeoPay';
        $bankPayment->transaction_id = 'FAKE_TRANSACTION';
        $bankPayment->amount = (integer)(round($booking->prepay * 100));
        $bankPayment->currency_id = $booking->currency_id;
        $bankPayment->currency_code = $booking->currency_code;
        $bankPayment->status = 'created';
        $bankPayment->service_id = $booking->id;
        $bankPayment->service_type = get_class($booking);
        $bankPayment->user_id = $user->id;
        $bankPayment->save();

        $bankPayment->status = 'payed';
        $bankPayment->save();

        $booking->status = 'payed';
        $booking->save();
        return $bankPayment;
    }
}
