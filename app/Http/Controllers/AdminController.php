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
    public function indexLogs()
    {
        $logs = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->get();
        return view('auditoria.index');//, compact('logs'));
    }
}