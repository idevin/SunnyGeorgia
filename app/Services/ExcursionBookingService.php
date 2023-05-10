<?php
/**
 * Created by PhpStorm.

 * Date: 12.03.2018
 * Time: 14:44
 */

namespace App\Services;


use App\Http\Requests\ExcursionBookingRequest;
use App\Models\Excursions\ExcursionAvailability;
use App\Models\Excursions\ExcursionBooking;
use App\User;

class ExcursionBookingService extends BaseBookingService
{

    protected $request;
    protected $customer;


    public function __construct(ExcursionBookingRequest $request, User $customer)
    {
        $this->request = $request;
        $this->customer = $customer;
    }

    public function order()
    {

        $availability = ExcursionAvailability::findOrFail($this->request->input('excursion_availability_id'));
        //$availability->amount = $availability->amount - $availability->bookPayed();

        $excursion = $availability->excursion()->first();

        $this->setCurrency($excursion->currency);

        $booking = new ExcursionBooking();
        $booking->excursion_id = $excursion->id;
        $booking->excursion_availability_id = $availability->id;
        $booking->customer_id = $this->customer->id;

        $booking->date_time_in = $availability->date . ' ' . $availability->time;
        $booking->date_in = $availability->date;
        $booking->time_in = $availability->time;

        $booking->qty_adults = ($excursion->type == "person") ? $this->request->input('amount_adults', 0) : 0;

        $booking->qty_child = ($excursion->type == "person") ? $this->request->input('amount_child', 0) : 0;
        $booking->qty_baby = ($excursion->type == "person") ? $this->request->input('amount_baby', 0) : 0;

        $booking->qty_kids = ($excursion->type == "person") ? $booking->qty_child + $booking->qty_baby : 0;

        $booking->customer_notes = str_limit($this->request->input('notes'), 1000);

        $booking->group_pid = ($excursion->type == "group") ? $this->request->input('group_pid') : null;
        if ($booking->group_pid) {
            $item = $excursion->prices->firstWhere('id', $booking->group_pid);
            if ($item && $item->price_type === 'group') {
                $booking->group_pid = $this->request->input('group_pid');
                $booking->sub_total = $item['price'];
            }
        } else {
            $booking->group_pid = null;
            $localPriceAdult = $excursion->prices[0]['price'];
            $localPriceBaby = $excursion->prices[1]['price'];
            $localPriceChild = $excursion->prices[2]['price'];
            $booking->sub_total = $localPriceBaby * $booking->qty_baby + $localPriceChild * $booking->qty_child + $localPriceAdult * $booking->qty_adults;
        }

        $costService = new ExcursionCostService();
        $costService->price($booking->sub_total);

        if ($excursion->partner->vat && $excursion->prepay) {
            $costService->prepayPercent($excursion->prepay);
        } else {
            $costService->prepayPercent($excursion->commission);
        }

        $booking->currency_code = $excursion->currency->code;
        $booking->currency_id = $excursion->currency->id;

        $booking->tax = $costService->tax();
        $booking->prepay = $costService->prepay();
        $booking->total = $costService->cost();
        $booking->save();

        $this->booking = $booking;
        return $this->booking;
    }


}
