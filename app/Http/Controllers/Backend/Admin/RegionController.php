<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Forms\RegionForm;
use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class RegionController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin']);
        $this->formBuilder = $formBuilder;
    }

    public function regionsData()
    {
        $regions = Region::all();

        return datatables()
            ->collection($regions)
            ->addColumn('action',function ($role) {
                $edit_route = route('admin.settings.regions.edit',$role);
                $delete_route = route('admin.settings.regions.destroy',$role);
                $another_actions = [
                    [
                        'name' => 'Ajouter une ville',
                        'route' => route('admin.settings.cities.index',$role)
                    ]
                ];
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route','another_actions'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Region|null $region
     * @return Form
     */
    private function getForm(?Region $region = null): Form
    {
        $region = $region ?: new Region();
        return $this->formBuilder->create(RegionForm::class, [
            'model' => $region
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
        return view('admin.regions.index',compact('form'));
    }

    /**
     * Edit a resource in storage.
     *
     * @param  Region id $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $region = Region::find($id);
        $form = $this->getForm($region);
        //$region = Region::where('status','<=',1)->get();
        $user = auth()->user();//We need the current user's id for the generated_by field

        return view('admin.regions.index',compact('form'));
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

        Region::create($data);

        return redirect()->route('admin.settings.regions.index')->with('success','Une region a été créée avec succès!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $region)
    {
        $form = $this->getForm();
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();
        $region = Region::find($region);
        //dd($region);
        /* $slug = Str::slug($form->getFieldValues()['name']);
        $data = array_merge($data,compact('slug')); */

        $region->update($data);
        //Region::create($data);

        return redirect()->route('admin.settings.regions.index')->with('success','La region a été éditée avec succès!');
    }
}
