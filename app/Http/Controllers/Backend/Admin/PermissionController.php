<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Forms\PermissionForm;
use App\Models\Permission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class PermissionController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin']);
        $this->formBuilder = $formBuilder;
    }

    public function permissionData()
    {
        $permissions = Permission::all();

        return datatables()
            ->collection($permissions)
            ->addColumn('roles',function ($permission) {
                return implode(' | ',$permission->roles->pluck('name')->toArray());
            })
            ->addColumn('action',function ($permission) {
                $edit_route = route('admin.settings.security.permissions.edit',$permission);
                $delete_route = route('admin.settings.security.permissions.destroy',$permission);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Permission|null $permission
     * @return Form
     */
    private function getForm(?Permission $permission = null): Form
    {
        $permission = $permission ?: new Permission();
        return $this->formBuilder->create(PermissionForm::class, [
            'model' => $permission
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
        return view('admin.permissions.index',compact('form'));
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

        Permission::create($data);
        return redirect()->route('admin.settings.security.permissions.index')->with('success','La nouvelle permission a été créée avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return Application|Factory|View
     */
    public function edit(Permission $permission)
    {
        $form = $this->getForm($permission);
        return view('admin.permissions.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return RedirectResponse
     */
    public function update(Permission $permission)
    {
        $form = $this->getForm($permission);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $permission->update($data);
        return redirect()->route('admin.settings.security.permissions.index')->with('success','La permission a été mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Permission $permission
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Permission $permission)
    {
        if($permission->users_count == 0){
            $permission->delete();
            return redirect()->back()->with('success','La permissiona été supprimée avec succès!');
        }
        return redirect()->back()->with('error','La permission que vous avez tentez de supprimer, est affectée à des utilisateurs');
    }
}
