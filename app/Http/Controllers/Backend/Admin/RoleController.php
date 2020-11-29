<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Forms\RoleForm;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
                $another_actions = [
                    [
                        'name' => 'Permissions',
                        'route' => route('admin.settings.security.roles.permissions',$role)
                    ]
                ];
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
        return view('admin.roles.index',compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $form = $this->getForm();
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        Role::create($data);
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
        $form = $this->getForm($role);
        return view('admin.roles.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(Role $role)
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
