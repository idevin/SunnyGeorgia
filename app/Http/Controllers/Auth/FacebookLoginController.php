<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.08.2018
 * Time: 18:32
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SoftRegistrationService;
use App\User;
use Laravel\Socialite\Two\InvalidStateException;
use Log;
use Socialite;

class FacebookLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $fbUser = Socialite::driver('facebook')->user();
        } catch (InvalidStateException $e) {
            Log::warning($e->getMessage());
            $fbUser = Socialite::driver('facebook')->stateless()->user();
        }

        if (!$fbUser || empty($fbUser->getEmail())) return redirect()->route('main')
            ->with(['status' => 'error', 'msg' => 'Something going wrong with Facebook']);

        $user = User::whereEmail($fbUser->getEmail())->first();

        if ($user) {
            \Auth::guard()->login($user);
        } else {
            $user = app(SoftRegistrationService::class)
                ->email($fbUser->getEmail())
                ->setEmailVerified(true)
                ->setName($fbUser->getName())
                ->setNickname($fbUser->getNickname())
                ->create();

            \Auth::guard()->login($user);
        }

        return redirect()->route('main', ['locale' => $user->locale ?? 'ru'])->with(['status' => 'success', 'msg' => 'You have been authenticated with Facebook profile.']);
    }
}
