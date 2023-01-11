<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        return view('cabinet.dashboard');
    }
}