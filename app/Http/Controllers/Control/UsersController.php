<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::latest()->with('roles')->paginate(25);
        $roles = Role::all();
        return view('control.users.index', compact('users', 'roles'));
    }

    public function view(User $user)
    {
        $partner = $user->partner;
        return view('control.users.view', compact('user', 'partner'));
    }

    public function bookings(User $user)
    {
        $excursionBookings = $user->excursionBookings()->get();
        $tourBookings = $user->tourBookings()->get();

        $orders = $tourBookings->concat($excursionBookings)
            ->sortByDesc('created_at')
            ->keyBy('created_at')->slice(0, 100);
        return view('control.users.bookings.index', compact('user', 'orders'));
    }

    public function update(User $user, Request $request)
    {
        $user->trusted = $request->input('trusted', false);
        $user->save();
        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function userAdmin(User $user)
    {
        if ($user->hasRole('admin')) {
            $user->detachRole('admin');
        } else {
            $user->attachRole('admin');
        }
        return back();
    }

}
