<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;


/**
 * @group Role
 *
 * @authenticated
 */

class RoleController extends Controller
{

    // function __construct()
    // {
    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }


    public function index()
    {
        $roles = Role::orderBy('id','DESC')->paginate();
        return view('roles.index',compact('roles'));

    }


    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        try {
          $role = Role::create(['name' => $request->input('name')]);
          $role->syncPermissions($request->input('permission'));

          return redirect()->route('role.index')
          ->withSuccess('Role created successfully');
        } catch (\Throwable $th) {
            return redirect()->route('role.index')
            ->with('error',$th->getMessage());
        }


    }

    public function show(Role $role)
    {
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->get();
            return view('roles.show',compact('role','rolePermissions'));

    }


    public function edit($id)
    {
      try {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

            return view('roles.edit',compact('role','permission','rolePermissions'));

      } catch (\Throwable $th) {
        return redirect()->route('role.index')
        ->with('error',$th->getMessage());
      }

    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        try {

         $default_roles = config('defaults.roles');
        if (in_array($role->name, $default_roles)) {
            foreach($default_roles as $roleName) {
                if ($role->name == $roleName && $request->input('name') != $roleName) {
                    return redirect()->route('roles.index')
                    ->with('error','it is not possible to remove a default group');
                }
            }
        }
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));

           return redirect()->route('role.index')->with('success','Role updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('roles.index')
            ->with('error',$th->getMessage());
        }
    }

    public function destroy(Role $role)
    {

      $default_roles = config('defaults.roles');
      if (in_array($role->name, $default_roles)) {
        return redirect()->route('roles.index')
        ->with('error','it is not possible to remove a default group');

      }

      try {
          $role->delete();
          return redirect()->route('roles.index')
          ->with('success','Role deleted successfully');
      } catch (\Throwable $th) {
        return redirect()->route('roles.index')
        ->with('error',$th->getMessage());
      }

    }
}
