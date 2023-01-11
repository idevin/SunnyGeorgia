<?php

namespace App\Http\Controllers\Site;

use App\BankPayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\TourBookingRequest;
use App\Services\GeoPay\GeoPayPaymentService;
use App\Services\OrderService;
use App\Services\SoftRegistrationService;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TourBookingController extends Controller
{

    public function postBooking(TourBookingRequest $request)
    {

        if (\Auth::guest()) {
            $this->validate($request, [
                'email' => 'required|string|email|max:255|unique:users',
                'mobile' => 'string'
            ]);

            $soft = app(SoftRegistrationService::class);
            $soft->email($request->input('email'))->mobile($request->input('mobile', ''));
            $customer = $soft->create();
            if (!($customer instanceof User)) {
                abort(500);
            }
        } else {
            $customer = \Auth::user();
        }

        $bookingService = OrderService::make($request, $customer);

        if ($bookingService->success()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'status' => 'error', 'msg' => $bookingService->errorFirst()]);
        }
    }

    public function checkout1($id, Request $request)
    {
        $user = $request->user();
        $booking = $user->tourBookings()->findOrFail($id);
        $tour = $booking->tour;
        $guestsCount = $booking->qty_adults + $booking->qty_kids + $booking->qty_additional;
        $guests = $booking->guests;

        return view('site.tours.checkout1', compact('booking', 'tour', 'guestsCount', 'guests'));
    }

    public function postForPay($tourBookingId, Request $request)
    {
        $user = \Auth::user();
        $tourBooking = $user->tourBookings()->findOrFail($tourBookingId);

        if ($request->has('mobile') && !$user->mobile_confirmed) {
            $user->mobile_number = $request->input('mobile');
            $user->save();
        }

//        $data = json_encode([
//            'method' => 'justPay',
//            'apiKey' => 'E0A049B3B13D4418879060E0A3A4E850',
//            'apiSecret' => '4B5FC369C13745EF8A71283A82FA6AD2',
//            'data' => [
//                'amount' => 100,
//                'currency' => 'USD',
//                'callback' => 'https://sunnygeorgia.travel',
//                'callbackError' => 'https://sunnygeorgia.travel',
//                'hookUrl' => 'https://sunnygeorgia.travel',
//                'lang' => 'EN',
//                'preauthorize' => false
//            ],
//            'split' => [
//                [
//                    'iban' => 'GE33TB0000000000000000',
//                    'amount' => 1,
//                    'payIn' => 10
//                ],
//                [
//                    'iban' => 'GE33TB0000000000000001',
//                    'amount' => 1,
//                    'payIn' => 10
//                ]
//            ]
//        ]);
//
//        $client = new Client();
//dd($data);
//        $response = $client->request('POST', 'https://payze.io/api/v1', [
//            'body' => $data,
//            'headers' => [
//                'Accept' => 'application/json',
//                'Content-Type' => 'application/json',
//            ],
//        ]);

//        dd($response->getBody()->getContents());

//        dd($tourBooking->tour->partner);

        $bankPayment = new BankPayment();
        $bankPayment->system = 'PayZee';
        $bankPayment->transaction_id = '';
        $bankPayment->amount = (integer)(round($tourBooking->prepay * 100));
        $bankPayment->currency_id = $tourBooking->currency_id;
        $bankPayment->currency_code = $tourBooking->currency_code;
        $bankPayment->status = 'created';
        $bankPayment->service_id = $tourBookingId;
        $bankPayment->service_type = get_class($tourBooking);
        $bankPayment->user_id = \Auth::id();
        $bankPayment->save();

        $geoPayService = new GeoPayPaymentService();
        $geoPayService->id($bankPayment->id);
        $geoPayService->amount($bankPayment->amount, $bankPayment->currency_code);
        $link = $geoPayService->link();


        if (\App::environment('production')) {
            return redirect($link);
        } else {
            //DEVELOP mode
            if (rand(0, 1))
                return redirect(route('geopay.success', ['payment' => $bankPayment->id]));
            else
                return redirect(route('geopay.fail', ['payment' => $bankPayment->id]));
        }
    }

    public function checkout2($id, Request $request)
    {
        $user = $request->user();
        $booking = $user->tourBookings()->findOrFail($id);
//        if ($booking->status !== 'paid') {
//            return redirect(route('tours.checkout1', $id));
//        }
        $tour = $booking->tour;
        $tourPartner = $tour->partner;
        $tourUser = $tour->user;
        $guestsCount = $booking->qty_adults + $booking->qty_kids + $booking->qty_additional;
        $guests = $booking->guests;
        return view('site.tours.checkout2', compact('user', 'tour', 'booking', 'guestsCount', 'guests', 'tourPartner', 'tourUser'));
    }
}
