<?php

namespace Tests\Unit\Tours;

use App\Services\TourCostService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CostTest extends TestCase
{
    public function costProvider()
    {
        return [
            [100, 100, 30, 0, 1.83, 18, 12, 17],
            [1000, 1000, 300, 0, 18.31, 180, 120, 170],
            [10000, 10000, 3000, 0, 183.05, 1800, 1200, 1700],
        ];
    }

    /**
     * @dataProvider costProvider
     */
    public function testCost($price, $cost, $prepay, $addTax, $tax, $payout, $revenue)
    {
//        $price = 100;
//        $cost = 105.4;
//        $prepay = 35.4;
//        $payout = 20;
        $prepayPercent = 30;

        $costServ = new TourCostService();
        $costServ->price($price)
            ->vatPayer(false)
            ->prepayPercent($prepayPercent);

        $this->assertEquals($cost, $costServ->cost());
        $this->assertEquals($prepay, $costServ->prepay());
        $this->assertEquals($addTax, $costServ->additionalTax());
        $this->assertEquals($tax, $costServ->tax());
        $this->assertEquals($payout, $costServ->payout());
        $this->assertEquals($revenue, $costServ->revenue());
    }
}
