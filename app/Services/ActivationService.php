<?php

namespace App\Services;

use App\Notifications\EmailActivationLink;
use App\Notifications\EmailActivationLinkAndPassword;
use App\Repositories\ActivationRepository;
use App\Traits\Utils;
use App\User;
use Illuminate\Mail\Mailer;

class ActivationService
{
    protected $mailer;

    protected $activationRepo;

    protected $resendAfter = 24;

    public function __construct(Mailer $mailer, ActivationRepository $activationRepo)
    {
        $this->mailer = $mailer;
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMail($user)
    {
        if ($user->email_verified) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);
        Utils::sendNotification($user, new EmailActivationLink($token));
    }

    public function sendActivationMailWithPassword($user, $password)
    {

        if ($user->email_verified) {
            return;
        }

        $token = $this->activationRepo->createActivation($user);

        Utils::sendNotification($user, new EmailActivationLinkAndPassword($token, $password));
    }

    public function activateUser($token)
    {
        $activation = $this->activationRepo->getActivationByToken($token);

        if ($activation === null) {
            return null;
        }

        $user = User::query()->find($activation->user_id);

        $user->email_verified = true;

        $user->save();

        $this->activationRepo->deleteActivation($token);

        return $user;

    }

    private function shouldSend($user)
    {
        $activation = $this->activationRepo->getActivation($user);
        return $activation === null || strtotime($activation->created_at) + 60 * 60 * $this->resendAfter < time();
    }
}
