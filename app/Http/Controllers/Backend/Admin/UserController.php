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
        $this->middleware(['auth','verified','role:super-admin|admin|chef-vendeur|vendeur'],['except' => ['updateInfosPerso','updatePWD','assignRole','assignRoleCheckout']]);
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
            "street"        => "nullable",
            "age_group"     => "nullable",
            "mobile_phone"  => "nullable",
            "num_tel"       => "nullable",
        ]);
        $user = User::find($request->input('id'));
        if(isset($data['gender']))
            $data['gender'] = intval($data['gender']);
        if($user->update($data)){
            return redirect()->back()->with("success","Vos informations ont été mise à jour 111");
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
     * this will setup all data needed by the Braintree gateaway.
     */
    public function assignRole(Request $request)
    {
        $data = $request->validate([
            'user_id' => "required",
            'role_id' => "required"
        ]);

        $title  = $request->form_payment_title;
        $user   = User::find($data['user_id']);
        $token  = \App\Models\Payment::buildPaymentToken();
        //We populare the sessions
        session([
            "token" => $token,
            "price" => 5,
            "product_name" => "role",
            "product_id" => $data['role_id'],
            "user_details" => [
                        'user_id'   => $user->id,
                        'prenom'    => $user->prenom,
                        'name'      => $user->name,
                        'email'     => $user->email
                    ],
            "form_action" => route('user.assign_role_checkout'),
            "payment_title" => $title
            ]);

        return view('payments.payment_page');
    }
    /**
     * 
     * this method will execute the checkout and assign the purchased role to the user
     * It also send email notification and save the reansaction in the database 
     */
    public function assignRoleCheckout(Request $request)
    {
        if(!session('token'))
            return redirect()->route("welcome") ;

        $user = User::find(session('user_details')['user_id']);
        if(!$user){
            return redirect()->route('welcome')->with("error", "Nous avons du mal à associer votre profil à l'achat. Assurez-vous que vous êtes connecté");
        }
        //We get the nonce generated by the braitree gateaway and pass it to the Payment::checkout method
        $nonce  = $request->payment_method_nonce;
        $payment  = \App\Models\Payment::checkout($nonce);

        if ($payment['status'] === 'SUCCESS') {
            $role = \App\Models\Role::find(session('product_id'));
            $user->giveRole($role);

            $message = "Nous avons bien reçu votre transaction. \nLa fonction $role->name vous a été assignée.\nVous pouvez maintenant, exécuter l'ensemble des actions spécifiques à cette fonction.";
            //We send the email notification to the user
            $user->notify((new \App\Notifications\PaymentReceived($user, $message))->delay(now()->addMinutes(10)));
            //We now need to save the transaction to the table before return
            $transaction = $payment["transaction"];
            //If we get the paypal index , user paid with paypal. If not we get the card type and the last four digits
            $payment_method = isset($transaction->paypal)?"Paypal-".$transaction->paypal['payerEmail']:$transaction->creditCard['cardType']."-".$transaction->creditCard['last4'];
            \App\Models\Payment::create([
                "user_id" => $user->id,
                "payment_method" => $payment_method,
                "payment_id" => $transaction->id,
                "purchassable_id" => $role->id,
                "purchassable_type" => "App\Models\Role",
                "amount" => session("price"),
            ]);
            //And we destroy the session
            session()->forget(["token","user_details"]);

            return view('payments/success_payment',['message' => $message]);
        } else {
            $errors = $payment['messages'];
            return view("payments/failed_payment",compact("errors"));
        }
    }

    public function destroy(User $user)
    {
        $user->profile_status = 4;
        $user->save();
        return redirect()->back()->with("success", "Le profile a été supprimé");
    }
}
