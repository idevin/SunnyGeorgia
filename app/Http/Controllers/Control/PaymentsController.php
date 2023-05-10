<?php
/**
 * Created by PhpStorm.

 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\BankPayment;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = BankPayment::with('user', 'service')->latest()->paginate(25);
        return view('control.payments.index', compact('payments'));
    }
}