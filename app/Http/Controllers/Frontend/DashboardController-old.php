<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function users()
    {
    	$users = User::all();
    	/*$organisations = User::all();
    	$events = Event::all();
    	$announcements = Announcement::all();*/
        //return view('admin.dashboard', compact("users","organisations","events","announcements"));
        return view('admin.dashboard', compact("users"));
    }
}
