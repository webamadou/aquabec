<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caracteristic;
use App\Models\CaracteristicOption;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Forms\CaracteristicOptionsForm;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class CaracteristicOptionController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|admin']);
        $this->formBuilder = $formBuilder;
    }

    public function optionsData($caracteristic)
    {
        $caracteristics = CaracteristicOption::where('caracteristic_id', $caracteristic)
                                                ->orderby('name','asc')
                                                ->with('caracteristic')
                                                ->get();

        return datatables()
            ->collection($caracteristics)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.edit_caracteristicOption',$item);
                $delete_route = route('admin.settings.delete_caracteristicOption',$item);

                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param CaracteristicOption|null $category
     * @return Form
     */
    private function getForm($caracteristic, ?CaracteristicOption $caracteristicOption = null): Form
    {
        $caracteristicOption = $caracteristicOption ?: new CaracteristicOption();
        return $this->formBuilder->create(CaracteristicOptionsForm::class, [ 'model' => $caracteristicOption, '' ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index($caracteristic)
    {
        $caracteristic  = Caracteristic::find($caracteristic);
        $options = CaracteristicOption::where('caracteristic_id', $caracteristic->id)
                                                ->orderby('name','asc')
                                                ->with('caracteristic')
                                                ->get();
        return view('admin.caracteristic_options.index',compact('caracteristic','options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'caracteristic_id' => 'required'
        ]);
        $slug = Str::slug($request->name);
        $data = array_merge($data,compact('slug'));
        CaracteristicOption::create($data);

        return redirect()->route('admin.settings.caracteristicOption',$data['caracteristic_id'])->with('success','L\'option a été créée avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Caracteristic $caracteristic
     * @return Application|Factory|View
     */
    public function edit($caracteristic, $option_id)
    {
        $option = CaracteristicOption::find($option_id);
        //dd($option->name);
        $options = CaracteristicOption::where('caracteristic_id', @$caracteristic)
                                                ->orderby('name','asc')
                                                ->with('caracteristic')
                                                ->get();
        //$caracteristics = $caracteristic->caracteristic;

        return view('admin.caracteristic_options.index',compact('option','options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Caracteristic $caracteristic
     * @return RedirectResponse
     */
    public function update(Request $request,CaracteristicOption $option)
    {
        //dd($option->name);
        $data = $request->validate([
                        'name' => 'required',
                        'caracteristic_id' => 'required'
                    ]);
        $option->update($data);

        return redirect()
                        ->route('admin.settings.caracteristicOption',$option->caracteristic_id)
                        ->with('success','L\option a été mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Caracteristic $caracteristic
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(CaracteristicOption $option)
    {
      //  dd($option);
        if($option){
            $option->delete();
            return redirect()->back()->with('success','L\'option a été supprimée avec succès!');
        }
        return redirect()->back()->with('error','Impossible de supprimer cette option');
    }
}
