<?php
/**
 * Created by PhpStorm.

 * Date: 18.04.2018
 * Time: 12:54
 */

namespace App\Http\Controllers\Payment;


use App\BankPayment;
use App\Models\Excursions\ExcursionBooking;
use App\Models\Tours\TourBooking;
use App\Services\GeoPay\GeoPayResponseService;
use Auth;
use Illuminate\Http\Request;
use Log;

class GeoPayController
{

    public function getBack(Request $request)
    {
        Log::info($request, [$request->method(), $request->path()]);
        return response()->json(['ok']);
    }

    public function postBack(Request $request)
    {
        Log::info('geopay post back log', ['request' => $request->all(), 'method' => $request->method()]);

        $xmlResponse = simplexml_load_string($request->input('params', ''));
        if (isset($xmlResponse->params)) {

            $gpResponse = new GeoPayResponseService();
            $gpResponse->response($request->input('params', ''));
            if ($gpResponse->valid()) {
                $payment = BankPayment::find($gpResponse->id());
                if ($payment) {
                    $payment->transaction_id = $gpResponse->transactionCode();
                    $payment->status = $gpResponse->success() ? 'payed' : strtolower($gpResponse->result() . ' ' . $gpResponse->resultCode());
                    $payment->save();
                } else {
                    Log::error('Wrong payment', ['request' => $request->all(), 'id' => $gpResponse->id(), 'gpResponse' => $gpResponse]);
                }
                return $gpResponse->xmlSuccess();
            }
        }
        return response()->json(['fail']);
    }

    public function success(Request $request)
    {
        if ($request->has('payment') && Auth::check()) {
            $user = Auth::user();
            $payment = $user->payments()->find((int)$request->input('payment'));
            if ($payment) {

                $service = $payment->service;
                if ($service instanceof TourBooking) {
                    return redirect(route('tours.checkout2', ['id' => $service->id]))
                        ->with([
                            'status' => 'success',
                            'msg' => trans('checkout.Payment success')
                        ]);
                } elseif ($service instanceof ExcursionBooking) {
                    return redirect(route('excursions.checkout2', ['id' => $service->id]))
                        ->with([
                            'status' => 'success',
                            'msg' => trans('checkout.Payment success') . ".<br>" . trans('checkout.Confirmation sent to email')
                        ]);
                }
            }
        }
        return view('site.payment.success');
    }

    public function fail(Request $request)
    {
        if ($request->has('payment') && Auth::check()) {
            $user = Auth::user();
            $payment = $user->payments()->find((integer)$request->input('payment'));
            if ($payment) {
                $service = $payment->service;
                if ($service instanceof TourBooking) {
                    return redirect(route('tours.checkout1', ['id' => $service->id]))->withErrors([
//                        'status' => 'error',
                        'msg' => trans('checkout.Payment failed')
                    ]);

                } elseif ($service instanceof ExcursionBooking) {
                    return redirect(route('excursions.checkout1', ['id' => $service->id]))->withErrors([
//                        'status' => 'error',
                        'msg' => trans('checkout.Payment failed')
                    ]);
                }

            }
        }
        return view('site.payment.fail');
    }
}
