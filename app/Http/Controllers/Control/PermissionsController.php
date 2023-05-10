<?php
/**
 * Created by PhpStorm.

 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{

    public function index()
    {

        $user = \Auth::user();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('control.permissions.index', compact('permissions', 'roles'));
    }

    public function syncRoles(Request $request)
    {


//        dd($request->input('roles'));
        $rolesIds = $request->input('roles');

        foreach ($rolesIds as $roleId => $permissionsIds) {

            $role = Role::findOrFail($roleId);
//            $permissions = Permission::whereIn('id', array_keys($permissionsIds));
            $role->syncPermissions(array_keys($permissionsIds));
//            $role->save();
        }
        return back();
    }

}