<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckEmail;
use App\Http\Requests\CheckUniqueEmail;

class RegisterController extends Controller
{
    public function checkEmail(CheckEmail $request)
    {
        return response()->json('ok');
    }

    public function checkUniqueEmail(CheckUniqueEmail $request)
    {
        return response()->json('ok');
    }
}
