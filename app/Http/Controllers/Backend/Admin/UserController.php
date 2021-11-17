<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Rules\CheckOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
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

use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified','role:super-admin|admin|chef-vendeur|vendeur'],['except' => ['updateInfosPerso','updatePWD','assignRole','assignRoleCheckout']]);
    }

    public function usersData()
    {
        $users = User::select('id','name','prenom','username','slug','email','updated_at')->with('roles')->where('profile_status','<=',1)->get();

        return datatables()
            ->collection($users)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.users.edit',$item->id);
                $delete_route = route('admin.users.destroy',$item->id);
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('profile_status','<',3)
                            ->with('roles');
            return Datatables::of($data)
                ->addIndexColumn()
                /* ->addColumn('publication',function ($row) {
                    $annonce_status = "";
                    if($row->lock_publication)
                        return '<span class="badge badge-warning position-relative"><span class="text-danger"><i class="fa fa-ban"></i></span> Publication bloquée: ';
                    switch (intval($row->publication_status)){
                        case 0:
                            $annonce_status = '<span class="badge badge-warning font-bold">Bouillon</span>';
                            break;
                        case 1:
                            $annonce_status = '<span class="badge badge-success font-bold">Publiée</span>';
                            break;
                        case 2:
                            $annonce_status = '<span class="badge badge-primary font-bold">Privée</span>';
                            break;
                        case 4:
                            $annonce_status = '<span class="badge badge-danger font-bold">Suprimée</span>';
                            break;

                        default:
                            break;
                    }
                    $validation_status = intval($row->validated) === 1?'<span class="badge badge-success"><i class="fa fa-check"></i> Validé</span>':(intval($row->validated > 1)?'<span class="badge badge-danger">Rejeté</span>':'<span class="badge badge-primary">Validation en attente</span>');
                    return $validation_status."<br>".$annonce_status;
                }) */
                ->addColumn('id',function ($row) {
                    return $row->id;
                })
                ->addColumn('name',function ($row) {
                    return  '<strong><i class="fa fa-user"></i> <a href="'.route('admin.users.show',$row->id).'" class="text-link">'.@$row->username.'<br>'.$row->prenom.' '.$row->name.'</a></strong>';
                })
                ->addColumn("email", function($row){
                    return @$row->email;
                })
                ->addColumn('roles',function($row){
                    $roles = $row->roles;
                    $fonctions = "";
                    foreach ($roles as $key => $role) {
                        $fonctions .= '<div class="badge badge-primary">'.$role->name.'</div>';
                    }
                    return $fonctions;
                })
                ->addColumn('updated_at', function($row){
                    return @$row->updated_at;
                })
                ->addColumn('action',function ($row) {
                    $edit_route = route("admin.users.edit",$row->id);
                    /* $modal_togglers = [
                        [
                            'name' => "Valider l'événement",
                            'route' => route('admin.validation_event',$row->id),
                            'modal_title' => "Confirmer ou rejeter la validation de l'événement <strong>$row->title</strong>"
                        ]
                    ]; */

                    return view('layouts.back.datatables.actions-btn',compact('edit_route'));
                })
                ->addColumn('created_at', function($row){
                    return @$row->created_at;
                })/*
                ->addColumn('owner', function($row){
                    $retour = $row->owned?$row->owned->username:"";
                    if($row->owned->id !== $row->posted->id)
                        $retour .= '<br><strong> Postée par :'. @$row->posted->username.'</strong>';

                    return $retour;
                })
                ->addColumn('region_id', function($row){
                    return '<strong>Region : </strong>'.@$row->region->name.'<br><strong>Ville : </strong>'.@$row->city->name;
                })
                ->addColumn('category_id', function($row){
                    return @$row->category->name;
                }) */
                ->filter(function ($instance) use ($request) {
                    if ($request->get('filter_name') != '') {
                        $name =  $request->get('filter_name');
                        $instance->where('name','LIKE', "%$name%");
                    }
                    if ($request->get('filter_prenom') != '') {
                        $prenom =  $request->get('filter_prenom');
                        $instance->where('prenom','LIKE', "%$prenom%");
                    }
                    if ($request->get('filter_username') != '') {
                        $username =  $request->get('filter_username');
                        $instance->where('username','LIKE', "%$username%");
                    }
                    if ($request->get('filter_id') != '') {
                        $instance->where('id', $request->get('filter_id'));
                    }
                    if ($request->get('filter_roles') != '') {
                        // $postal_code = $request->get('postal_code');
                        $name = $request->get('filter_roles');
                        $instance->whereHas("roles", function($q) use($name){$q->where('name', $name);});
                    }
                    if ($request->get('price_type') == '3' || $request->get('price_type') == '2') {
                        $instance->where('price_type', $request->get('price_type'));
                    }
                    if ($request->get('organisateur') != '' ) {
                        $instance->where('organisation_id','<=', $request->get('organisateur'));
                    }
                    if ($request->get('pub_type') != '') {
                        $instance->where('publication_status', $request->get('pub_type'));
                    }
                    if ($request->get('created_at') != '') {
                        $date_min = $request->get('created_at').' 00:00:00';
                        $date_max = $request->get('created_at').' 23:59:59';
                        $instance->where('created_at', '>=',$date_min)
                                ->where('created_at', '<=',$date_max);
                    }
                    if ($request->get('updated_at') != '') {
                        $date_min = $request->get('updated_at').' 00:00:00';
                        $date_max = $request->get('updated_at').' 23:59:59';
                        $instance->where('updated_at', '>=',$date_min)
                                ->where('updated_at', '<=',$date_max);
                    }
                    if ($request->get('filter__date') != '') {
                        $dates = $request->get('filter__date');
                        $instance->where('dates','LIKE', "%$dates%");
                    }
                    if ($request->get('owner') != '') {
                        $instance->where('dates', $request->get('owner'));
                    }
                    if ($request->get('filter_title') != '') {
                        $title = $request->get('filter_title');
                        $instance->where('title','LIKE', "%$title%");
                    }
                    /* if (!empty($request->get('search'))) {
                        $instance->where(function($w) use($request){
                            $search = $request->get('search');
                            $w->orWhere('title', 'LIKE', "%$search%")
                                ->orWhere('dates', 'LIKE', "%$search%")
                                ->orWhere('id', 'LIKE', "%$search%");
                        });
                    } */
                })
                ->order(function ($instance) use ($request){
                        $order = @$request->get('order')[0];
                        switch ($order['column']) {
                            case 0:
                                $instance->orderby('id', $order['dir']);
                                break;
                            /*case 1:
                                $instance->orderby('events.title', $order['dir']);
                                break;
                            case 2:
                                $instance
                                    ->join('event_dates','event_dates.event_id','=','events.id')
                                    ->orderby('event_dates.event_date', $order['dir']);
                                break;
                            case 3:
                                $instance->orderby('events.region_id', $order['dir'])
                                            ->orderby('events.city_id', $order['dir']);
                                break;
                            case 4:
                                $instance->orderby('events.owner', $order['dir']);
                                break;
                             case 5:
                                $instance->orderby('region_id', $order['dir'])
                                            ->orderby('city_id', $order['dir']);
                                break;
                            case 6:
                                $instance->orderby('events.publication_status', $order['dir']);
                                break;
                            */

                            default:
                                $instance->orderby('updated_at', "desc");
                                break;
                        }
                        $instance
                            /* ->join('event_dates','event_dates.event_id','=','events.id')
                            ->groupby('events.id') */
                            ->skip( @$request->get('start') )
                            ->take( @$request->get('lenght') );

                        // echo $instance->join('event_dates','event_dates.event_id','=','events.id')->groupby('events.id')->toSql();
                })
                ->rawColumns(['id','name','email','roles','updated_at','created_at','action'])
                ->make(true);
        }

        $roles = Role::orderby('name')->get();

        return view('admin.users.index', compact("roles"));
        // return view('admin.users.index');
    }

    public function show(User $user)
    {
        $current_user = auth()->user();
        if($current_user->hasRole('super-admin') || $current_user->hasRole('admin'))
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
    /**
     *
     */
    public function createVendeur()
    {
        $current_user   = auth()->user();
        $user           = new User();
        $region_list    = Region::pluck('name','id');
        $cities_list    = City::where('region_id',$user->region_id)->pluck('name','id');
        $age_group      = AgeRange::ageSelect();
        $title          = $current_user->hasRole('vendeur')?"Enregistrer un annonceur dans votre équipe":"Enregistrer un vendeur dans votre équipe";
        $role_name          = $current_user->hasRole('vendeur')?"vendeur":"annonceur";

        return view('user.vendeurs.cvcreate', compact('title','current_user','user','region_list','cities_list','age_group','role_name'));
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
        //If the password is changed we have to update the field must_update_password to force the user to change it's password
        // dd($data);
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
     *
     */
    public function editVendeur(User $user)
    {
        $current_user = auth()->user();
        $region_list = Region::pluck('name','id');
        $cities_list = City::where('region_id',$user->region_id)->pluck('name','id');
        $age_group   = AgeRange::ageSelect();

        return view('user.vendeurs.cvedit', compact('current_user','user','region_list','cities_list','age_group'));
    }
    /**
     *
     */
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        // dd($request->username);
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
            dd('fi erreur la');
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
            "name"          => "nullable",
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
