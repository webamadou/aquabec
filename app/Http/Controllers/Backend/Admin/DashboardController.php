<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User ;
use App\Models\Organisation ;
use App\Models\Event ;
use App\Models\Announcement ;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:super-admin|admin|banquier|banker']);
    }

    public function index()
    {
    	$users = User::all();
    	$organisations = User::all();
    	$events = Event::all();
        $announcements = Announcement::all();
        $current_user = auth()->user();
        return view('admin.dashboard', compact("users","organisations","events","announcements","current_user"));
    }


    public function autocomplete(Request $request)
    {
        $user = auth()->user();
        $input = strtolower( trim( $request->get('autocomplete_user') ) );

        $users = $user->recipientList()
                        ->where('username','LIKE',"%$input%")
                        ->orWhere('id',$input)
                        ->orderby('username')
                        ->select('id','name','prenom','username')
                        ->get();

        return response()->json($users);
    }
}
