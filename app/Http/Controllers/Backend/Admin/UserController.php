<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Rules\CheckOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate \Support\Str;
use Carbon\Carbon;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\storeUserRequest;
use App\Models\User;
use App\Models\City;
use App\Models\Event;
use App\Models\Region;
use App\Models\Role;
use App\Models\AgeRange;
use App\Models\Announcement;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:super-admin|admin|chef-vendeur|vendeur'],['except' => ['updateInfosPerso','updatePWD','assignRole']]);
    }

    public function usersData()
    {
        //$users = User::role(['membre','admin'])->with('roles')->get();
        $users = User::select('id','name','prenom','slug','email','updated_at')->where('profile_status','<=',1)->get();

        return datatables()
            ->collection($users)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.users.edit',$item);
                $delete_route = route('admin.users.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {

    	$users          = User::all();
    	$organisations  = User::all();
    	$events         = Event::all();
        $announcements  = Announcement::all();

        return view('admin.users.index', compact("users","organisations","events","announcements"));
        return view('admin.users.index');
    }

    public function show(User $user)
    {
        $current_user = auth()->user();
        if($current_user->hasRole('super-admin') || $user->hasRole('admin'))
            return view('admin.users.show', compact('user','current_user'));
    }
    public function create()
    {
        $user = new User();
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id'); 
        $age_group   = AgeRange::ageSelect();
        $vendors     = User::vendors()->where('id', '!=', $user->id )->get(['prenom','name','id']);
        $roles       = Role::pluck('name','id');

        return view('admin.users.create',compact('user','region_list','cities_list','age_group','vendors','roles'));
    }

    public function edit(User $user)
    {
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');       
        $age_group   = AgeRange::ageSelect();

        $vendors     = User::vendors()->where('id', '!=',$user->id)->get(['prenom','name','id']);
        $roles       = Role::pluck('name','id');

        return view('admin.users.edit',compact('user','region_list','cities_list','age_group','vendors','roles'));
    }
    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(storeUserRequest $request)
    {
        $data = $request->validated();
        //We generate a password for the user
        $password           = Str::random(8);
        $data['password']   = Hash::make($password);
        //$data['must_update_password'] = Str::random(35);
        //If the password is changed we have to update the field must_update_password to force the user to change it's password
        if($user = User::create($data)){
            $roles = Role::pluck('name','id');
            $last_role = '';//If at the end of the loop this var is still empty we need to assign a default role
            //We now need to loop through the roles and assign the checked role and remove the unchecked ones
            foreach ($roles as $key => $role) {
                if($request->input("role_$role")){
                    $last_role = $role;
                    $user->assignRole($role);
                }
            }
            if($last_role === '')
                $user->assignRole("membre");
            //We need to send the notification to the user 
            $user->notify(new \App\Notifications\NewAccount($user,$password));
            //Then we set users as verified
            $user->email_verified_at = Carbon::now();
            $user->save();
            $current_user = auth()->user();
            //Based on the role of the current user we will have a different 
            if($current_user->hasRole('super-admin') || $current_user->hasRole('admin')){
                return redirect()
                    ->route('admin.users.index')
                    ->with('success','Modifications enregistrées avec succès!');
            } elseif ($current_user->hasRole('chef-vendeur') || $current_user->hasRole('vendeur')) {
                return redirect()
                    ->route('vendeurs.my_team')
                    ->with('success','Modifications enregistrées avec succès!');
            }
        }
        return redirect()
                    ->route('welcome')
                    ->with('success',"Il s'est produit une erreur lors de l'enregistrement!");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $data = $request->validated();
        if($user->update($data)){
            $roles = Role::pluck('name','id');
            //We now need to loop through the roles and assign the checked role and remove the unchecked ones
            foreach ($roles as $key => $role) {
                if($request->input("role_$role")){
                    $user->assignRole($role);
                } else {
                    $user->removeRole($role);
                }
            }
            return redirect()
                            ->back()
                            ->with('success','Modifications enregistrées avec succès!');
        } else {
            return redirect()
                            ->back()
                            ->with('error',"Il s'est produit une erreur");
        }
    }
    public function getListUserAjax()
    {
        $res = User::select("name,id")
                ->where("name","LIKE","%{$request->term}%")
                ->where("id","%{$request->term}%")
                ->where("id", "!=", Auth::id())
                ->get();
    
        return response()->json($res);
    }

    public function updateInfosPerso(Request $request)
    {
        $data = $request->validate([
            "name"          => "required",
            "prenom"        => "nullable",
            "region_id"     => "nullable",
            "city_id"       => "nullable",
            "postal_code"   => "nullable",
            "gender"        => "nullable",
            "num_civique"   => "nullable",
            "age_group"     => "nullable",
            "mobile_phone"  => "nullable",
            "num_tel"       => "nullable",
        ]);
        $user = User::find($request->input('id'));
        if(isset($data['gender']))
            $data['gender'] = intval($data['gender']);
        if($user->update($data)){
            return redirect()->back()->with("success","Vos informations ont été mise à jour");
        }

        return redirect()->back()->with("error","Une erreur s'est produite!");
    }

    public function updatePWD(Request $request)
    {
        $request->validate([
            'current_password' =>  ['required', new CheckOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'new_confirm_password' => ['same:new_password']
        ]);

        $user = User::find(auth()->user()->id);
        if($user->update(['password' => Hash::make($request->new_password)])){
            return redirect()->back()->with("success", "Votre mot de passe a parfaitement été modifié!");
        }
    }
    /**
     * 
     * assign a role to a user through
     */
    public function assignRole(Request $request)
    {
        $data = $request->validate([
            'user_id' => "required",
            'role_id' => "required"
        ]);
        $user = User::select('id')->find($data['user_id']);
        $role = \App\Models\Role::select('id','name','currency_id','free_credit','paid_credit')->find($data['role_id']);
        //We add a restriction for the banker and super-admin profiles  
        if(strtolower($role->name) === 'banquier' || strtolower($role->name) === 'super-admin'|| strtolower($role->name) === 'admin'|| strtolower($role->name) === 'chef vendeur')
            return redirect()->back();
        if($user->hasRole('super-admin')){//We prevent to change the super-admin role
            return redirect()->back();
        }

        if($user = $user->assignRole($role->name)){
            $free_credit_amount = intval($role->free_credit);
            $paid_credit_amount = intval($role->paid_credit);
            $pivot_fields       = [
                                    'free_currency' => $free_credit_amount,
                                    'paid_currency' => $paid_credit_amount
                                  ];
            $user->setUserCurrency($role->currency_id , $pivot_fields);

            return redirect()->back()->with('success',"Inscription validée");
        }
        return redirect()->back();
    }

    public function destroy(User $user)
    {
        $user->profile_status = 4;
        $user->save();
        return redirect()->back()->with("success", "Le profile a été supprimé");
    }
}
