<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 07.09.2018
 * Time: 20:13
 */

namespace App\Services;


use App\Currency;

class BaseBookingService
{

    protected $errors = [];
    protected $currency;

    protected $booking;

    public function errorFirst()
    {
        return current($this->errors);
    }

    public function success()
    {
        return $this->booking ? true : false;
    }

    protected function error($msg)
    {
        $this->errors[] = $msg;
        return $this;
    }

    protected function setCurrencyById($curId)
    {
        $cur = Currency::findOrFail($curId);
        $this->setCurrency($cur);
        return $this;
    }

    protected function setCurrency(Currency $currency)
    {
        $this->currency = $currency;
        return $this;
    }

    protected function setCurrencyByCode($code)
    {
        $cur = Currency::whereCode($code)->firstOrFail();
        $this->setCurrency($cur);
        return $this;
    }

}