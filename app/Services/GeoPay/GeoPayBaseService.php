<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 19.03.2018
 * Time: 13:10
 */

namespace App\Services\GeoPay;


class GeoPayBaseService
{
    protected $PASS;

    public function __construct()
    {
        $this->PASS = config('geopay.password');
    }

    public function signature(array $params)
    {
        return md5(implode('', $params) . $this->PASS);
    }

}
