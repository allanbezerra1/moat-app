<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;



class UserController extends Controller
{
    private $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->userServices = $userServices;
    }

    public function index()
    {
        $user = $this->userServices->All();
        return view('users.index', compact('user'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create', compact('roles'));
    }

    public function edit($id)
    {
        $user = $this->userServices->FindById($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
    }

    public function store(Request $request)
    {
        //Validate data
        $this->validate($request, [
            'name' => 'required',
            'full_name' => 'required|unique:users',
            'password' => 'required|same:password_confirmation',
            'roles' => 'required'
        ]);
        //Send failed response if request is not valid

        try {
            DB::beginTransaction();
            //Request is valid, create new user
            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = $this->userServices->Create($input);
            $user->assignRole($request->input('roles'));
            DB::commit();
            return redirect()->route('user.index')
            ->with('success', 'user create success');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('user.index')
            ->withErrors($th->getMessage());
        }
    }

    public function show($id)
    {
        $user = $this->userServices->findByid($id);
        return view('users.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        //Request is valid, updated user
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|min:6|max:50',
            'roles' =>'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return back();
        }
        try {
            DB::beginTransaction();

            $input = $request->all();
            if(!empty($input['password'])){
                $input['password'] = bcrypt($input['password']);
            }else{
                $input = Arr::except($input,array('password'));
            }
            $user = $this->userServices->update($id, $input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $users =User::find($id);
            $users->assignRole($request->input('roles'));

            DB::commit();

            return $user;

        } catch (\Throwable $th) {
            DB::rollBack();
            return back();
        }
    }
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
                $user = $this->userServices->destroy($id);
                DB::commit();
            return $user;
        } catch (\Throwable $th) {
            DB::rollBack();
            return back();
        }
    }
}
