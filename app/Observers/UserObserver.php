<?php

namespace App\Observers;


use App\Notifications\UserCreated;
use App\Traits\Utils;
use App\User;

class UserObserver
{
    public function created(User $user)
    {
        $admins = User::whereRoleIs('admin')->get();


      // when not on prod url we use mailtrap. Mailtrap can't process more then 2 emails at once on free plan
      if(config('app.url') === 'https://sunnygeorgia.travel') {
        Utils::sendNotification($admins, new UserCreated($user));
      } else {
        Utils::sendNotification($admins[0], new UserCreated($user));
      }
    }
}