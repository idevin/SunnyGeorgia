<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 19.03.2018
 * Time: 13:10
 */

namespace App\Services\GeoPay;


class GeoPayResponseService extends GeoPayBaseService
{
    protected $id;
    protected $bankId;
    protected $amount;
    protected $status;

    protected $params;
    protected $xml;

    public function id()
    {
        return $this->id;
    }

    public function amount()
    {
        return $this->amount;
    }

    public function success()
    {
        if ($this->xml['RESULTCODE'] == '000' && $this->xml['RESULT'] == 'OK') {
            return true;
        } else {
            return false;
        }
    }

    public function result()
    {
        return $this->xml['RESULT'];
    }

    public function resultCode()
    {
        return $this->xml['RESULTCODE'];
    }

    public function transactionCode()
    {
        return $this->xml['BANKTRANSACTIONID'];
    }

    /**
     * @param $xmlResponse string
     * @return boolean
     */
    public function response(string $xmlResponse): bool
    {
        $xmlResponse = simplexml_load_string($xmlResponse);
        $this->xml = (array)$xmlResponse->params;

        $this->params = [
            'MERCHANTTRANSACTIONID' => $this->xml['MERCHANTTRANSACTIONID'],
            'BANKTRANSACTIONID' => $this->xml['BANKTRANSACTIONID'],
            'RESULT' => $this->xml['RESULT'],
            'RESULTCODE' => $this->xml['RESULTCODE'],
            'RRN' => $this->xml['RRN'],
            'CARDNUMBER' => $this->xml['CARDNUMBER'],
        ];

        if ($this->valid()) {
            $this->id = $this->params['MERCHANTTRANSACTIONID'];
            $this->bankId = $this->params['BANKTRANSACTIONID'];
            return true;
        }
        return false;
    }

    public function valid()
    {
        if ($this->xml['SIGNATURE'] == $this->signature($this->params)) {
            return true;
        } else {
            return false;
        }
    }

    public function xmlSuccess($result = 1, $description = 'OK')
    {
        $str = '<register-payment-response><result>';
        $str .= '<code>' . $result . '</code>';
        $str .= '<desc>' . $description . '</desc>';
        $str .= '</result></register-payment-response>';
        return $str;
    }
}