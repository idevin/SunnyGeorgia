<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.05.2018
 * Time: 18:46
 */

namespace App\Observers;


use App\Notifications\PartnerCreated;
use App\Partner;
use App\Traits\Utils;
use App\User;

class PartnerObserver
{
    public function created(Partner $partner)
    {
        $admins = User::whereRoleIs('admin')->get();
        Utils::sendNotification($admins, new PartnerCreated($partner));
    }
}
