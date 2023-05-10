<?php
/**
 * Created by PhpStorm.

 * Date: 11.12.2017
 * Time: 16:52
 */

namespace App\Services;


use App\Notifications\MobileConfirm;
use App\Repositories\MobileActivationRepository;
use App\User;

class MobileActivationService
{
    protected $activationRepo;

    public function __construct(MobileActivationRepository $activationRepo)
    {
        $this->activationRepo = $activationRepo;
    }

    public function sendActivationMessage(User $user)
    {
        if ($user->mobile_confirmed) {
            return;
        }

        $code = $this->activationRepo->createActivation($user);

        $user->notify(new MobileConfirm($code));
    }

    public function activateUser(User $user, $token)
    {
        $activation = $this->activationRepo->getActivationByToken($user, $token);

        if ($activation === null) {
            return null;
        }

        if ($user->mobile_confirmed) {
            return $user;
        }

        $user->mobile_confirmed = true;

        $user->save();

        $this->activationRepo->deleteActivation($user);

        return $user;

    }
}