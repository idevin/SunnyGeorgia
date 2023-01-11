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

class GoogleLoginController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {

//        User {#1202 ▼
//        +token: "ya29.Glv4BXLutX0qTeJesZzhw-NoqzxXX1TFZELrpJXuuUXYh9MkYodTq32fpxL2H7h1loJAS9vRakarSQH-wVmeFCEWG88iLV5mLCQnYPhnMQoK4oqXfpAfdako4XgS"
//        +refreshToken: null
//        +expiresIn: 3600
//        +id: "117211049297763557460"
//        +nickname: "Мефодий"
//        +name: "Кирилл"
//        +email: "nitogel@gmail.com"
//        +avatar: "https://lh6.googleusercontent.com/-Xbud2tQ1_yw/AAAAAAAAAAI/AAAAAAABBFY/2ufAEAVmi6g/photo.jpg?sz=50"
//        +user: array:15 [▼
//    "kind" => "plus#person"
//    "etag" => ""jb1Xzanox6i8Zyse4DcYD8sZqy0/BECp7KQ7MqvGn7Xi8VIv4MV-NFo""
//    "nickname" => "Мефодий"
//    "gender" => "male"
//    "emails" => array:1 [▶]
//    "objectType" => "person"
//    "id" => "117211049297763557460"
//    "displayName" => "Кирилл"
//    "name" => array:2 [▼
//      "familyName" => ""
//      "givenName" => "Кирилл"
//    ]
//    "url" => "https://plus.google.com/117211049297763557460"
//    "image" => array:2 [▶]
//    "isPlusUser" => true
//    "language" => "ru"
//    "circledByCount" => 80
//    "verified" => false
//  ]
//  +"avatar_original": "https://lh6.googleusercontent.com/-Xbud2tQ1_yw/AAAAAAAAAAI/AAAAAAABBFY/2ufAEAVmi6g/photo.jpg"
//}
        // $user->token;

        // All Providers
//        $user->getId();
//        $user->getNickname();
//        $user->getName();
//        $user->getEmail();
//        $user->getAvatar();

        try {
            $authUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            Log::warning($e->getMessage());
            $authUser = Socialite::driver('facebook')->stateless()->user();
        }

        if (!$authUser) return redirect()->route('main')->with(['status' => 'error', 'msg' => 'Something going wrong with Google']);

        $user = User::whereEmail($authUser->getEmail())->first();

        if ($user) {
            \Auth::guard()->login($user);
        } else {
            $soft = app(SoftRegistrationService::class);
            $user = $soft->email($authUser->getEmail())
                ->setEmailVerified(true)
                ->setName($authUser->getName())
                ->setNickname($authUser->getNickname())
                ->create();

            \Auth::guard()->login($user);
        }

        return redirect()->route('main', ['locale' => $user->locale ?? 'ru'])->with(['status' => 'success', 'msg' => 'You have been authenticated with Google profile.']);
    }
}