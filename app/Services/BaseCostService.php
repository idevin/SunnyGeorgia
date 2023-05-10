<?php
/**
 * Created by PhpStorm.

 * Date: 31.05.2018
 * Time: 18:46
 */

namespace App\Services;


class BaseCostService
{
    protected $price = 0;
    protected $vatPayer = false;
    protected $prepayPercent = 10;
    protected $revenuePercent = 12;
    protected $vatPercent = 18;
    protected $bankCommission = 2.4;


    protected $taxAmount;
    protected $prepay;


    public function price($price)
    {
        $this->price = ceil($price);
        return $this;
    }

    public function vatPayer(bool $vat)
    {
        $this->vatPayer = $vat;
        return $this;
    }

    public function prepayPercent($percent)
    {
        if ($percent) {
            $this->prepayPercent = $percent;
        }
        return $this;
    }

    public function cost()
    {
//        if (!$this->vatPayer) {
//            $totalTaxPercent = $this->prepayPercent * $this->vatPercent / 10000;
//        } else {
//            $totalTaxPercent = 0;
//        }
//
//        $cost = $this->price + ($this->price * $totalTaxPercent);
//        return round($cost, 2);

        return $this->price;
    }

    public function payout(): float
    {
//        return round($this->prepay() - $this->tax() - $this->revenue(), 2);
        return round($this->prepay() - $this->revenue(), 2);
    }

    public function prepay()
    {
        $prepay = ($this->price * $this->prepayPercent / 100) + $this->additionalTax();
        return round($prepay, 2);
    }

    public function additionalTax(): float
    {
//        return $this->vatPayer ? 0.00 : round($this->price * $this->prepayPercent * $this->vatPercent / 10000, 2);
        return 0;
    }

    public function revenue(): float
    {
        return round($this->price * $this->revenuePercent / 100, 2);
    }

    public function tax(): float
    {
//        if (!$this->vatPayer) {
//            return $this->additionalTax();
//        } else {
        $totalTax = $this->revenue() * $this->vatPercent / (100 + $this->vatPercent);
        return round($totalTax, 2);
//        }
    }
}
