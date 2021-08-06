<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/album';

    protected $name;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/album')
                        ->withSuccess('Signed in');
        }

        return redirect("login")->withErrors("Sorry, we couldn't find an account with this username. Please check you're using the right username and try again.");
    }


}
