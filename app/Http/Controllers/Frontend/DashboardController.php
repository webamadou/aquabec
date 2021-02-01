<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
use App\Models\Role;
use App\Models\CreditsTransfersLog;
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

        $fonction_except = ['admin','super-admin','membre','chef vendeur','vendeur','Banquier'];
        $fonctions   = Role::select('name','id','description')->whereNotIn("name",$fonction_except)->get();

        return view('user.profile.infosperso',compact('region_list','cities_list', 'age_group','user','default_tab','fonctions'));
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
    /**
     * 
     * return the data for the datatable.
     */
    public function userSentTransactions()
    {
        $user = auth()->user();
        $logs = CreditsTransfersLog::with('sentBy','sentTo','credit')
                                    ->where('sent_by',$user->id)
                                    ->orWhere('sent_to',$user->id)
                                    ->orderBy("created_at","desc")
                                    ->get();

        return datatables()
            ->collection($logs)
            ->addColumn('action',function ($logs) {
                $edit_route = route('banker.credits.edit',$logs);
                $delete_route = route('banker.credits.destroy',$logs);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            /* ->rawColumns(['action']) */
            ->make(true);
    }
}
