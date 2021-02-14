<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\AgeRange;
use App\Models\CreditsTransfersLog;
use Mail;
use App\Mail\UserMails;

class DashboardController extends Controller
{
    public function index()
    {
        $notifications = \App\Models\Notifications::all();
        return view('user.dashboard', compact('notifications'));
    }
    /**
     * 
     * page of the vendors of a chief vendor
     */
    public function myTeam(){
        $current_user = auth()->user();
        if($current_user->can("vendor", $current_user)){
            return view('user.vendeurs.my_team', compact('current_user'));
        }
    }
    /**
     * Return the datable of the vendeur of a chef vendeur on datatable format
     */
    public function myTeamData($user_id = null) {
        $user_id = $user_id === null?auth()->user()->id:$user_id;
        //we get the vendeurs of the currently authenticated user
        $logs = User::vendors()->where('godfather', $user_id)->where('profile_status','<=',1)->get();
        if(auth()->user()->hasRole('vendeur')){
            $logs = auth()->user()->godchildren()->where('profile_status','<=',1)->get();
        }

        return datatables()
            ->collection($logs)
            ->addColumn('action', function($item){
                $edit_route = route('vendeurs.edit_vendeur',$item);
                return view('layouts.back.datatables.actions-btn', compact('edit_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showProfile(User $user)
    {
        if($user->profile_status >1)
            return $this->notAvailable();
        $current_user = auth()->user();
        return view('user.profile.show', compact('user','current_user'));
    }

    public function createVendeur()
    {
        $current_user   = auth()->user();
        $user           = new User();
        $region_list    = Region::pluck('name','id');
        $cities_list    = City::where('region_id',$user->region_id)->pluck('name','id');
        $age_group      = AgeRange::ageSelect();
        $title          = $current_user->hasRole('vendeur')?"Enregistrer un annonceur dans votre équipe":"Enregistrer un vendeur dans votre équipe";

        return view('user.vendeurs.cvcreate', compact('title','current_user','user','region_list','cities_list','age_group'));
    }
    public function editVendeur(User $user)
    {
        $current_user = auth()->user();
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');
        $age_group   = AgeRange::ageSelect();

        return view('user.vendeurs.cvedit', compact('current_user','user','region_list','cities_list','age_group'));
    }
    public function infosPerso($default_tab=null){
        //the default_tab var is use to set default tab to display in the page 
        $user = auth()->user();
        $default_tab = $default_tab == null ? 'account': $default_tab ;
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');

        $age_group   = AgeRange::ageSelect();

        $fonction_except = ['admin','super-admin','membre','chef vendeur','vendeur','Banquier'];
        $fonctions   = Role::select('name','id','description')->whereNotIn("name",$fonction_except)->get();

        return view('user.profile.infosperso',compact('region_list','cities_list', 'age_group','user','default_tab','fonctions'));
    }

    public function selectCities(Request $request)
    {
        $res = Region::find($request->id)->cities->pluck('name','id');

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
            /* ->addColumn('action',function ($logs) {
                $edit_route = route('banker.credits.edit',$logs);
                $delete_route = route('banker.credits.destroy',$logs);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            }) */
            /* ->rawColumns(['action']) */
            ->make(true);
    }

    public function notAvailable()
    {
        return view('user.not_available');
    }
}
