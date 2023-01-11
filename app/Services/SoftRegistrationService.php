<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 03.07.2018
 * Time: 16:17
 */

namespace App\Services;


use App\User;
use Auth;

class SoftRegistrationService
{

    protected $email;
    protected $nickname;
    protected $name;
    protected $firstName;
    protected $lastName;
    protected $mobile;
    protected $password;
    protected $activationService;

    protected $emailVerified = false;

    protected $defaultRole = 'user';

    public function __construct(ActivationService $activationService)
    {
        $this->activationService = $activationService;
    }

    /**
     * @param $email
     * @return $this
     * @throws \Exception
     */
    public function email($email)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Wrong email');
        }
        $this->email = $email;
        return $this;
    }

    public function mobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    public function firstName($text)
    {
        $this->firstName = $text ?? '';
        return $this;
    }

    public function lastName($text)
    {
        $this->lastName = $text ?? '';
        return $this;
    }

    public function setEmailVerified(bool $verified)
    {
        $this->emailVerified = $verified;
        return $this;
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @return \App\User
     */
    public function create(): User
    {
        $this->password = $this->generatePassword();
        $user = User::query()->create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => strtolower($this->email),
            'email_verified' => (bool)$this->emailVerified,
            'mobile_number' => $this->mobile,
            'currency' => currency()->getUserCurrency(),
            'password' => bcrypt($this->password),
        ]);

        $user->attachRole($this->defaultRole);

        $this->guard()->login($user);

        //Send EMAIL verification link
        $this->activationService->sendActivationMailWithPassword($user, $this->password);

        return $user;
    }

    /**
     * @param int $length
     * @return string
     */
    protected function generatePassword($length = 6)
    {
        return str_random($length);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * @param $nickname
     * @return $this
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
