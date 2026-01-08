<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
     public function index()
    {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return view('admin.dashboard');
        }

        if ($role === 'agent') {
            return view('agent.dashboard');
        }

        if ($role === 'user') {
            return view('user.dashboard');
        }

        abort(403);
    }
}
