<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\Notifications::all();
        return view('user.dashboard', compact('notifications'));
    }
}
