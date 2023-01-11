<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivationService;

class ActivationController extends Controller
{

    protected $activationService;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet/profile';

    /**
     * Create a new controller instance.
     * @param  ActivationService $activationService ;
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->activationService = $activationService;
    }

    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect($this->redirectTo);
        }
        return abort(404);
    }
}
