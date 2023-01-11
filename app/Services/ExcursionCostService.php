<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 26.03.2018
 * Time: 16:55
 */

namespace App\Services;


class ExcursionCostService extends BaseCostService
{
    public function price($price)
    {
        $this->price = round($price, 2);
        return $this;
    }

}