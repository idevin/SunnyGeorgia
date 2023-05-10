<?php
/**
 * Created by PhpStorm.

 * Date: 19.03.2018
 * Time: 13:10
 */

namespace App\Services\GeoPay;


class GeoPayPaymentService extends GeoPayBaseService
{
    protected $id;
    protected $amount;
    protected $currency = 'USD';
    protected $lang = 'EN';

    protected $link;

    protected $URL;

    public function __construct()
    {
        parent::__construct();
        $this->URL = config('geopay.url');
    }

    /**
     * @param $id string Internal Payment id
     * @return $this
     */
    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param $lang string
     * @return $this
     * @throws \Exception
     */
    public function lang($lang)
    {
        $lang = strtoupper($lang);
        if ($lang == 'KA') $lang = 'GE';

        $allowedLangs = [
            'EN', 'GE',
        ];

        if (in_array($lang, $allowedLangs)) {
            $this->lang = $lang;
        } else {
            throw new \Exception('Wrong lang');
        }
        return $this;
    }

    /**
     * @param $amount integer
     * @param $currency string
     * @return $this
     */
    public function amount($amount, $currency)
    {
        $this->amount = is_int($amount) ? $amount : (integer)$amount;

        $this->currency($currency);
        return $this;
    }

    /**
     * @param $currency string
     * @return $this
     */
    public function currency($currency)
    {
        $currency = strtoupper($currency);
        $allowedCurrencies = [
            'USD'
        ];

        if (in_array($currency, $allowedCurrencies)) {
            $this->currency = $currency;
        } else {
            $this->amount = intval(currency()->convert($this->amount / 100, $currency, 'usd', false) * 100);
        }
        return $this;
    }

    /**
     * @return string
     */
    public function link()
    {
        $args = [
            'mtranzaction' => $this->id,
            'langcode' => $this->lang,
            'currency' => $this->currency,
            'amount' => $this->amount
        ];

        $args['hash'] = $this->signature($args);
//        $this->link = $this->URL . '?' . http_build_query($args, null, '&amp;');
        $this->link = $this->URL . '?' . http_build_query($args);

        return $this->link;
    }

}
