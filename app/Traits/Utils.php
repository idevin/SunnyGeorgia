<?php
/**
 * Created by PhpStorm.
 * User: id
 * Date: 25/02/19
 * Time: 17:42
 */

namespace App\Traits;


use App\User;
use Cocur\Slugify\Slugify;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

trait   Utils
{
    public static function slugify($string = '', $uniqueId = true)
    {
        $slugifyer = new Slugify();

        $options = [
            'lowercase' => true,
            'rulesets' => ['default']
        ];

        $string = $slugifyer->slugify($string, $options);

        $string = preg_replace('/[^\d\w\-\_]+/i', '-', $string);
        $string = trim($string, '-');

        if (empty($string) && $uniqueId == true) {
            $string = uniqid();
        }

        return $string;
    }

    public static function sendNotification($users, $action)
    {
        $notifiables = collect();
        $admins = User::whereRoleIs('admin')->whereSysEmails(1)->get();

        if ($users instanceof Collection) {
            $notifiables = $users;
        } else {
            $notifiables[] = $users;
        }

        // when not on prod url we use mailtrap. Mailtrap can't process more then 2 emails at once on free plan
        if(config('app.url') === 'https://sunnygeorgia.travel') {
            if (count($admins) > 0) {
                $notifiables = $notifiables->merge($admins);
            }
        }

        Notification::send($notifiables, $action);
    }
}
