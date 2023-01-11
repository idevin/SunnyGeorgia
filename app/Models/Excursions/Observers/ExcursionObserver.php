<?php

namespace App\Models\Excursions\Observers;


use App\Models\Excursions\Excursion;
use App\Notifications\Admin\ExcursionCreate;
use App\Notifications\Admin\RequestCommissionUpdate;
use App\Notifications\User\AcceptCommissionUpdate;
use App\Traits\Utils;
use App\User;
use Illuminate\Support\Facades\Request;

class ExcursionObserver
{
    public function created(Excursion $excursion)
    {
        $admins = User::whereRoleIs('admin')->get();
        Utils::sendNotification($admins, new ExcursionCreate($excursion));
    }

    public function updated(Excursion $excursion)
    {
        if ($excursion->isDirty('commission_proposal')) {
            if (Request::segment(1) === 'cabinet') {
                $admins = User::whereRoleIs('admin')->get();
                Utils::sendNotification($admins, new RequestCommissionUpdate($excursion));
            }
            if (Request::segment(1) === 'control') {
                $user = User::query()->findOrFail($excursion->user_id);
                Utils::sendNotification($user, new AcceptCommissionUpdate($excursion));
            }
        }
    }
}
