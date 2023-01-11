<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.05.2018
 * Time: 18:46
 */

namespace App\Observers;


use App\BankPayment;

class BankPaymentObserver
{

    /**
     * @param BankPayment $bankPayment
     */
    public function updated(BankPayment $bankPayment)
    {
        //test
        $originalBankPayment = $bankPayment->getRawOriginal();
        $status = isset($originalBankPayment['status']) ?: 'created';

        if ($status !== $bankPayment->status) {
            switch ($bankPayment->status) {
                case('payed'):
                    $booking = $bankPayment->service;
                    $booking->status = 'payed';
                    $booking->save();
                    break;
            }
        }

    }
}