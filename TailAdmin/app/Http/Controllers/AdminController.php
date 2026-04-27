<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $usuarios = User::with('role')->get();
        return view('admin.users', compact('usuarios'));
    }
}