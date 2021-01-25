<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
class DashboardController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\Notifications::all();
        return view('user.dashboard', compact('notifications'));
    }

    public function infosPerso($default_tab=null){
        //the default_tab var is use to set default tab to display in the page 
        $user = auth()->user();
        $default_tab = $default_tab == null ? 'account': $default_tab ;
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');
        // $age_group   = ['02_12' => '', '12_17', '18_24', '25_34', '35_44', '45_54', '55_64', '65_74', '75_+'];
        $age_group   = ['12_17' => 'moins de 17 ans',
                        '18_24' => 'de 18 à 24 ans',
                        '25_34' => 'de 25 à 34 ans',
                        '35_44' => 'de 35 à 44 ans',
                        '45_54' => 'de 45 à 54 ans',
                        '55_64' => 'de 55 à 64 ans',
                        '65_74' => 'de 65 à 74 ans',
                        '75_+'  => 'plus de 75 ans'];

        return view('user.profile.infosperso',compact('region_list','cities_list', 'age_group','user','default_tab'));
    }

    public function selectCities(Request $request)
    {
        $res = Region::find($request->id)->cities->pluck('name','id');
                /* ->where("name","LIKE","%{$request->term}%")
                ->where("id","%{$request->term}%")
                ->where("id", "!=", Auth::id())
                ->get(); */

        return response()->json($res);
    }
}
