<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Rules\CheckOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Event;
use App\Models\Announcement;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:super-admin|admin'],['except' => ['updateInfosPerso','updatePWD']]);
    }

    public function usersData()
    {
        $users = User::role(['user','admin'])->with('roles')->get();

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

    	$users = User::all();
    	$organisations = User::all();
    	$events = Event::all();
    	$announcements = Announcement::all();
      return view('admin.users.index', compact("users","organisations","events","announcements"));
        return view('admin.users.index');
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
}
