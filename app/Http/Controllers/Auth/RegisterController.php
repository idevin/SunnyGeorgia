<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivationService;
use App\Services\SoftRegistrationService;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';
    protected $activationService;

    /**
     * Create a new controller instance.
     *
     * @param ActivationService $activationService
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware('guest');
        $this->activationService = $activationService;
    }

    /**
     * @param Request $request
     * @return bool|mixed
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function softRegistration(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|unique:users|email'
        ]);

        $soft = app(SoftRegistrationService::class);
        $user = $soft->email($request->input('email'))
            ->mobile($request->input('mobile', ''))
            ->firstName($request->input('first_name'))
            ->lastName($request->input('last_name'))
            ->create();

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if ($request->ajax()) {
            //todo Отдавать юзера через ресурс
            if ($user->avatar) {
                $user->avatarUrl = $user->avatar->url;
            };
            $user->csrfToken = csrf_token();
            return response()->json([
                'success' => true,
                'msg' => trans('auth.Your registration was successful'),
                'user' => $user,
            ]);
        } else {
            return false;
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::query()->create([
            'first_name' => isset($data['first_name']) ? $data['first_name'] : '',
            'last_name' => isset($data['last_name']) ? $data['last_name'] : '',
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->attachRole('user');

        //Send EMAIL verification link
        $this->activationService->sendActivationMail($user);

        return $user;
    }
}
