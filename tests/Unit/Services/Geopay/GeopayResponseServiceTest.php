<?php

namespace Tests\Unit\Services\Geopay;

use App\Services\GeoPay\GeoPayResponseService;
use Tests\TestCase;

class GeopayResponseServiceTest extends TestCase
{
    public function testTimeoutResponse()
    {
        $gpResponse = new GeoPayResponseService();

        $smlString = "<transid>
           <params>
             <MERCHANTTRANSACTIONID>32</MERCHANTTRANSACTIONID>
             <BANKTRANSACTIONID>k15Y+I2NB6PpziXWZn70+zkQ2ws=</BANKTRANSACTIONID>
             <RESULT>TIMEOUT</RESULT>
             <RESULTCODE></RESULTCODE>
             <RRN></RRN>
             <CARDNUMBER></CARDNUMBER>
             <SIGNATURE>cda20c73480cb871c1e7c22c12cf1109</SIGNATURE>
           </params>
        </transid>";
        $gpResponse->response($smlString);

        $this->assertEquals('32', $gpResponse->id());
        $this->assertEquals('TIMEOUT', $gpResponse->result());
        $this->assertTrue($gpResponse->valid());
    }
}