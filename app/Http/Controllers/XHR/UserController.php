<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.04.2018
 * Time: 12:04
 */

namespace App\Http\Controllers\XHR;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function checkEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        if (User::whereEmail($request->input('email'))->count() > 0) {
            return response()->json(['success' => false, 'msg' => trans('auth.This email already registered')]);
        } else {
            return response()->json(['success' => true]);
        }
    }
}