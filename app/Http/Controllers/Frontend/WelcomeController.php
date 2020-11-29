<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function welcomePage()
    {

		$user = Auth::user();
		//dd($user->getRoleNames());
    	//Auth::logout();
        return view('frontend.welcome');
    }
}
