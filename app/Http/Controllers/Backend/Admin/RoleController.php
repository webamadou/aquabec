<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Forms\RoleForm;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\CreditPrice;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;

class RoleController extends Controller
{
    private $formBuilder;
    public $persmission_group = [
                          'base'      => 'Base',
                          'general'   => 'Gestion générale',
                          'users'     => 'Gestion des membres',
                          'events'    => 'Gestion des Événements',
                          'announcement' => 'Gestion des annonces classées',
                          'banker'    => 'Bankier'
                        ];

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin']);
        $this->formBuilder = $formBuilder;
    }

    /*
     * Get roles data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function roleData()
    {
        $roles = Role::all();

        return datatables()
            ->collection($roles)
            ->addColumn('users_count',function ($role) {
                return $role->users_count;
            })
            ->addColumn('action',function ($role) {
                $edit_route = route('admin.settings.security.roles.edit',$role);
                $delete_route = route('admin.settings.security.roles.destroy',$role);
                /* $another_actions = [
                    [
                        'name' => 'Permissions',
                        'route' => route('admin.settings.security.roles.permissions',$role)
                    ]
                ]; */
                $another_actions = [];
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route','another_actions'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Role|null $role
     * @return Form
     */
    private function getForm(?Role $role = null): Form
    {
        $role = $role ?: new Role();
        return $this->formBuilder->create(RoleForm::class, [
            'model' => $role
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $form = $this->getForm();

      	$users = User::all();
      	$organisations = User::all();
      	$events = Event::all();
      	$announcements = Announcement::all();
        return view('admin.roles.index',compact('form','users','organisations','events','announcements'));
    }

    public function create()
    {
      $form = $this->getForm();
      $role = new Role();
      $users = User::all();
      $organisations = User::all();
      $events = Event::all();
      $announcements = Announcement::all();
      $permission_array = $this->persmission_group;
      $permissions = Permission::where("guard_name","web")->get();
      return view('admin.roles.create',compact('form','users','organisations','events','announcements','role','permissions','permission_array')); }
    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $form = $this->getForm();

        $data = $request->validate([
            "name" => 'required|unique:roles',
            "events_price" => 'required',
            "date_credit" => 'required',
            "annoucements_price" => 'required',
        ]);
        $data['free_events'] = @$request->input("free_events") || 0;
        $data['free_annoncements'] = @$request->input("free_annoncements") || 0;
        $form->redirectIfNotValid();
        if($new_role = Role::create($data)){//If the role si saved successfully
            //We link the role to the checked permissions
            $permissions = Permission::where("guard_name","web")->get();
            foreach ($permissions as $key => $permission) {
                if($request->input("permission_".$permission->id)){
                    $new_role->givePermissionTo($permission->name);
                }
            }
            //We saved the credits prices
            //If nbr price is > 0 that means we have a least one credit price define
            if(intval($request->input("nbr_price_fields")) > 0){
                //We loop throug all the credit price fields
                for($i = 0; $i <= $request->input("nbr_price_fields"); $i++){
                    //We only save the not empty fields
                    $price          = trim($request->input("price-$i")) !== "" ?$request->input("price-$i"): 0;
                    $credit_amount  = trim($request->input("credit_amount-$i") !== "") ?$request->input("credit_amount-$i"): 0;
                    $role_id        = $new_role->id;

                    if($price != 0 && $credit_amount != 0){
                        $data = ['price' => $price, "credit_amount" => $credit_amount, "role_id" => $role_id];
                        CreditPrice::create($data);
                    }
                }
            }
        }
        return redirect()->route('admin.settings.security.roles.index')->with('success','Le nouveau role a été créé avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        $form = $this->getForm();
        $permission_array   = $this->persmission_group;

        $users              = User::all();
        $organisations      = User::all();
        $events             = Event::all();
        $announcements      = Announcement::all();
        $permissions        = Permission::where("guard_name","web")->get();

        return view('admin.roles.edit',compact('form','users','organisations','events','announcements','role','permissions','permission_array'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Request $request,Role $role)
    {
        //$form = $this->getForm();

        $data = $request->validate([
            "name" => 'required',
            "events_price" => 'required',
            "date_credit" => 'required',
            "annoucements_price" => 'required',
        ]);
        $data['free_events'] = @$request->input("free_events") || 0;
        $data['free_annoncements'] = @$request->input("free_annoncements") || 0;

        if($new_role = $role->update($data)){//If the role si saved successfully
            //We link the role to the checked permissions
            $permissions = Permission::where("guard_name","web")->get();
            foreach ($permissions as $key => $permission) {
                if($request->input("permission_".$permission->id)){
                    $role->givePermissionTo($permission->name);
                } else {
                    $role->revokePermissionTo($permission->name);
                }
            }
            //We saved the credits prices
            //If nbr price is > 0 that means we have a least one credit price define
            if(intval($request->input("nbr_price_fields")) > 0){
                //We loop throug all the credit price fields
                for($i = 1; $i <= $request->input("nbr_price_fields"); $i++){
                    //We only save the not empty fields
                    $id             = trim($request->input("price-$i")) !== "" ?$request->input("price-$i"): 0;
                    $price          = trim($request->input("price-$i")) !== "" ?$request->input("price-$i"): 0;
                    $credit_amount  = trim($request->input("credit_amount-$i") !== "") ?$request->input("credit_amount-$i"): 0;

                    $credit_price = $request->input("credit_id-$i") ? CreditPrice::find($request->input("credit_id-$i")): new CreditPrice();

                    if($price != 0 && $credit_amount != 0){
                        $credit_price->price            = $price ;
                        $credit_price->credit_amount    = $credit_amount ;
                        $credit_price->credit_amount    = $credit_amount ;
                        $credit_price->role_id          = $role->id ;

                        $credit_price->save();
                    } 
                }
            }
            //We now check if there was prices that was deleted
            $delete_prices = explode(',',$request->input("prices_deleted"));

            foreach ($delete_prices as $key => $value) {
                if($price = CreditPrice::where("id",$value)->select("id")->first()) {
                    $price->delete();
                }
            }
        }
        return redirect()->route('admin.settings.security.roles.edit', $role->id)->with('success','La fonction a été éditée avec succès!');
    }



    public function updateOld(Role $role)
    {
        $form = $this->getForm($role);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $role->update($data);
        return redirect()->route('admin.settings.security.roles.index')->with('success','Le role a été mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Role $role)
    {
        if($role->users_count == 0){
            $role->delete();
            return redirect()->back()->with('success','Le role a été supprimé avec succès!');
        }
        return redirect()->back()->with('error','Le role que vous avez tentez de supprimer, est affecté à des utilisateurs');
    }

    /**
     * @param Role $role
     * @return Application|Factory|View
     */
    public function getRolePermissions(Role $role)
    {
        $permissions = Permission::all();
        return \view('admin.roles.role-permissions',compact('role','permissions'));
    }

    public function assignRolePermissions(Request $request,Role $role)
    {
        $permissions = $request->except('_method','_token');
        if ($role->syncPermissions($permissions)) {
            return redirect()->route('admin.settings.security.roles.index')->with('success','Les permissions du role **'.$role->name.'** ont été mises à jour!');
        }
        return redirect()->route('admin.settings.security.roles.index')->with('error','Opps! quelque chose s\'est mal passé. Veuillez réessayé.');

    }
}
