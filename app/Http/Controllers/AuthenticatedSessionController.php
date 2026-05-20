<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticatedSessionController
{
    public function login(){
        #guest()->attempt(request()->only('email', 'password'));
        return view('login');
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('logout');
    }
}
