<?php

namespace App\Models\Tours\Observers;

use App\Models\Tours\Tour;
use App\Notifications\Admin\RequestCommissionUpdate;
use App\Notifications\Admin\TourCreate;
use App\Notifications\User\AcceptCommissionUpdate;
use App\Traits\Utils;
use App\User;
use Illuminate\Support\Facades\Request;

class TourObserver
{

    public function created(Tour $tour)
    {
        $admins = User::whereRoleIs('admin')->get();
        Utils::sendNotification($admins, new TourCreate($tour));
    }

    public function updated(Tour $tour)
    {
        if ($tour->isDirty('commission_proposal')) {
            if (Request::segment(1) === 'cabinet') {
                $admins = User::whereRoleIs('admin')->get();
                Utils::sendNotification($admins, new RequestCommissionUpdate($tour));
            }
            if (Request::segment(1) === 'control') {
                $user = User::query()->findOrFail($tour->user_id);
                Utils::sendNotification($user, new AcceptCommissionUpdate($tour));
            }
        }
    }
}
