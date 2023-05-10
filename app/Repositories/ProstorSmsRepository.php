<?php
/**
 * Created by PhpStorm.

 * Date: 12.12.2017
 * Time: 17:54
 */

namespace App\Repositories;


class ProstorSmsRepository
{

    public function balance()
    {
        $payload = [
            'login' => config('prostorsms.login'),
            'password' => config('prostorsms.password'),
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://api.prostor-sms.ru/messages/v2/senders/');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        dump(curl_exec($curl));

        dump(curl_error($curl));
    }
}
