<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Forms\OrganisationForm;
use App\Http\Controllers\Controller;
use App\Models\Organisation;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class OrganisationController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
        $this->formBuilder = $formBuilder;
    }

    public function organisationsData()
    {
        $organisations = Organisation::all();

        return datatables()
            ->collection($organisations)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.organisations.edit',$item);
                $delete_route = route('admin.organisations.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Organisation|null $organisation
     * @return Form
     */
    private function getForm(?Organisation $organisation = null): Form
    {
        $organisation = $organisation ?: new Organisation();
        return $this->formBuilder->create(OrganisationForm::class, [
            'model' => $organisation
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
        return view('admin.organisations.index',compact('form'));
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

        $slug = Str::slug($form->getFieldValues()['name']);
        $data = array_merge($data,compact('slug'));

        Organisation::create($data);

        return redirect()->route('admin.organisations.index')->with('success','Une organisation a été créée avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Organisation $organisation
     * @return Application|Factory|View
     */
    public function edit(Organisation $organisation)
    {
        $form = $this->getForm($organisation);
        return view('admin.organisations.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Organisation $organisation
     * @return RedirectResponse
     */
    public function update(Organisation $organisation)
    {
        $form = $this->getForm($organisation);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $slug = Str::slug($form->getFieldValues()['name']);
        $data = array_merge($data,compact('slug'));

        $organisation->update($data);
        return redirect()->route('admin.organisations.index')->with('success',"L'organisation a été mise à jour avec succès!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Organisation $organisation
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Organisation $organisation)
    {
        if($organisation->events_count == 0){
            $organisation->delete();
            return redirect()->back()->with('success',"L'organisation a été supprimée avec succès!");
        }
        return redirect()->back()->with('error','Impossible de supprimer cette organisation');
    }
}
