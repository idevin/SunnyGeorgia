<?php

namespace App\Http\Controllers\Site;

use App\BankPayment;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExcursionBookingRequest;
use App\Models\Excursions\ExcursionAvailability;
use App\Services\OrderService;
use App\Services\SoftRegistrationService;
use App\User;
use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ExcursionBookingController extends Controller
{

    public function postBooking(ExcursionBookingRequest $request)
    {
        if (Auth::guest()) {
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
            $customer = Auth::user();
        }

        $bookingService = OrderService::make($request, $customer);

        if ($bookingService->success()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'status' => 'error', 'msg' => $bookingService->errorFirst()]);
        }
    }

    public function checkout1($bookingId, Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            $token = $request->get('token');
            if (!$token) {
                abort(404);
            }

            $userId = null;

            try {
                $userId = decrypt($token, false);
            } catch (DecryptException $e) {
                abort(404);
            }

            $user = Auth::loginUsingId($userId);
            if (!$user) {
                abort(404);
            }
        }

        $booking = $user->excursionBookings()->findOrFail($bookingId);

        if ($booking->status === 'payed') {
            abort(404);
        }

        return view('site.excursions.checkout1', compact('booking'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws GuzzleException
     */
    public function postForPay($tourBookingId, Request $request)
    {
        $user = Auth::user();
        $booking = $user->excursionBookings()->findOrFail($tourBookingId);

        if ($request->has('mobile') && !$user->mobile_confirmed) {
            $user->mobile_number = $request->input('mobile');
            $user->save();
        }

        $partner = $booking->excursion->partner;

        $bankNumber = $partner->bank_number;

        $locale = strtoupper(session()->get('locale'));

        $ourComission = $booking->excursion->commission;

        $ourPercent = (($booking->total / 100) * $ourComission);
        $ourPercent = (($ourPercent / 100) * 2.9) + $ourPercent;


        $bankPayment = new BankPayment();
        $bankPayment->system = 'Payze';
        $bankPayment->transaction_id = '';
        $bankPayment->amount = (integer)(round($booking->prepay));
        $bankPayment->currency_id = $booking->currency_id;
        $bankPayment->currency_code = $booking->currency_code;
        $bankPayment->status = 'created';
        $bankPayment->service_id = $booking->id;
        $bankPayment->service_type = get_class($booking);
        $bankPayment->user_id = \Auth::id();
        $bankPayment->save();

        $data = [
            'method' => 'justPay',
            'apiKey' => 'E763C266B1E242558FEF73455875B11D',
            'apiSecret' => '7C9E35456CB341848A91CCABC6728441',
            'data' => [
                'amount' => $booking->prepay,
                'currency' => $booking->currency_code,
                'callback' => route('geopay.success', ['payment' => $bankPayment->id]),
                'callbackError' => route('geopay.fail', ['payment' => $bankPayment->id]),
                'hookUrl' => 'https://sunnygeorgia.travel',
                'lang' => $locale,
                'preauthorize' => false
            ],
            'split' => [
                [
                    'iban' => $bankNumber,
                    'amount' => ($booking->total / 100) * 18,
                    'payIn' => 10
                ],
                [
                    'iban' => 'GE90TB7531936030100001',
                    'amount' => round($ourPercent, 2),
                    'payIn' => 10
                ]
            ]
        ];

        $client = new Client();

        $response = $client->request('POST', 'https://payze.io/api/v1', [
            'body' => json_encode($data),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);
        $link = $body['response']['transactionUrl'];

        return redirect($link);
    }

    public function checkout2($id, Request $request)
    {
        $user = $request->user();
        $booking = $user->excursionBookings()->findOrFail($id);

        if ($booking->status === 'payed') {
            abort(404);
        }

        $availability = ExcursionAvailability::query()->findOrFail($booking->excursion_availability_id);
        $availability->amount = $availability->amount - $availability->bookPayed();
        $availability->save();

        $booking->update([
            'status' => 'payed',
            'price_changed' => 1
        ]);

        $excursion = $booking->excursion;
        $userPartner = $excursion->user;
        $partner = $excursion->partner;
        return view('site.excursions.checkout2', compact('user', 'booking', 'partner', 'userPartner'));
    }
}
