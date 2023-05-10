<?php
/**
 * Created by PhpStorm.

 * Date: 17.04.2018
 * Time: 12:12
 */

namespace App\Http\Validators;

use GuzzleHttp\Client;

class ReCaptcha
{
    public function validate(
        $attribute,
        $value,
        $parameters,
        $validator
    )
    {

        $client = new Client();

        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            ['form_params' =>
                [
                    'secret' => config('env.captchaSecret'),
                    'response' => $value
                ]
            ]
        );

        $body = json_decode((string)$response->getBody());
        return $body->success;
    }

}
