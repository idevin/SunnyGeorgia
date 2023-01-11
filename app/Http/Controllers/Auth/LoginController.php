<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if (Auth::check()) {
            URL::defaults(['locale' => Auth::user()->locale]);
        } else {
            URL::defaults(['locale' => config('app.locale')]);
        }
        $this->redirectTo = route('main');
    }

    public function redirectTo()
    {
        return URL::previous() ?: $this->redirectTo;
    }

    public function cabinetLogout(Request $request)
    {
        $this->logout($request);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

        session()->put('locale', $user->locale);
        app()->setLocale($user->locale);
        session()->put('currency', $user->currency);
        currency()->setUserCurrency($user->currency);

        //todo Отдавать юзера через ресурс
        if ($user->avatar) {
            $user->avatarUrl = $user->avatar->url;
        };

        if ($request->ajax()) {
            $user->csrfToken = csrf_token();
            return response()->json([
                'auth' => auth()->check(),
                'user' => $user,
                'intended' => $this->redirectPath(),
                'success' => true,
                'msg' => trans('auth.Your login was successful'),
            ]);
        }
    }
}
