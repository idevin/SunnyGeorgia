<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 12.12.2017
 * Time: 14:16
 */

namespace App\NotificationChannels\ProstorSms;


class ProstorSms
{
    /** @var string */
    protected $login;
    /** @var string */
    protected $password;
    /** @var string */
    protected $url;

    /**
     * Create a new Plivo RestAPI instance.
     *
     * @param array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->login = $config['login'];
        $this->password = $config['password'];
        $this->url = $config['url'];
    }

    public function send_message($data)
    {
        $payload = [
            'login' => $this->login,
            'password' => $this->password,
            'messages' => [
                [
                    'phone' => $data['mobile_number'],
                    'clientId' => 1,
                    'text' => $data['text']
                ],
            ],
            'sender' => config('app.name')
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
//        $result = 'llll';
        $errors = curl_error($curl);
//        $errors = null;
        return ['response' => $result, 'errors' => $errors];
    }
}
