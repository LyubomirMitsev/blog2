<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Gate;
use App\User;

class AdminController extends Controller
{

    use AuthenticatesUsers;

    public function showLoginForm() {
        return view('auth.login');
    }

    public function dashboard() {
        return view('admin.index');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
       return Auth::guard('admin');
    }
}
