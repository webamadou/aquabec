<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caracteristic;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Forms\CaracteristicForm;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class CaracteristicController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
        $this->formBuilder = $formBuilder;
    }

    public function caracteristicsData()
    {
        $caracteristics = Caracteristic::orderby('name','asc')->with('category')->get();

        return datatables()
            ->collection($caracteristics)
            ->addColumn('action',function ($caracteristics) {
                $edit_route = route('admin.settings.caracteristics.edit',$caracteristics);
                $delete_route = route('admin.settings.caracteristics.destroy',$caracteristics);

                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Caracteristics|null $category
     * @return Form
     */
    private function getForm(?Caracteristic $caracteristic = null): Form
    {
        $caracteristic = $caracteristic ?: new Caracteristic();
        return $this->formBuilder->create(CaracteristicForm::class, [
            'model' => $caracteristic
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
        return view('admin.caracteristics.index',compact('form'));
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

        /* if ($data['parent_id'] == null) {
            $data['parent_id'] = 0;
        } */

        Caracteristic::create($data);

        return redirect()->route('admin.settings.caracteristics.index')->with('success','La caractéristique a été créée avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Caracteristic $caracteristic
     * @return Application|Factory|View
     */
    public function edit(Caracteristic $caracteristic)
    {
        $form = $this->getForm($caracteristic);
        return view('admin.caracteristics.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Caracteristic $caracteristic
     * @return RedirectResponse
     */
    public function update(Caracteristic $caracteristic)
    {
        $form = $this->getForm($caracteristic);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        /* if ($data['parent_id'] == null) {
            $data['parent_id'] = 0;
        } */

        $caracteristic->update($data);
        return redirect()->route('admin.settings.caracteristics.index')->with('success','La caracteristic a été mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Caracteristic $caracteristic
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Caracteristic $caracteristic)
    {
        /* if($caracteristic->type == 'event' && $caracteristic->events_count == 0){
            $caracteristic->delete();
            return redirect()->back()->with('success','La catégorie a été supprimée avec succès!');
        } */

        if($caracteristic){
            $caracteristic->delete();
            return redirect()->back()->with('success','La caracteristics a été supprimée avec succès!');
        }
        return redirect()->back()->with('error','Impossible de supprimer cette catégorie');
    }
}
