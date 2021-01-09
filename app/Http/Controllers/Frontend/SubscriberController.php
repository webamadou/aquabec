<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriberController extends Controller
{
    public function summary(Subscription $subscription){
    	//$subs = Subscription::find($id);
    	$subs = $subscription;
    	return view("frontend.subscriber_summary", compact("subs"));
	}
	
	public function mySafe()
	{
		$user = auth()->user();
		return view('frontend.my_safe', compact("user"));
	}
}
