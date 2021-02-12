<?php

namespace App\Http\Controllers\Backend\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\AgeRange;
use App\Forms\AgeRangeForm;

class AgeRangeController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin']);
        $this->formBuilder = $formBuilder;
    }

    /**
     * @param AgeRange|null $AgeRange
     * @return Form
     */
    private function getForm(?AgeRange $agerange = null): Form
    {
        $agerange = $agerange ?: new AgeRange();
        return $this->formBuilder->create(AgeRangeForm::class, [
            'model' => $agerange
        ]);
    }

    public function eventAgeRangeData()
    {
        $age_ranges = AgeRange::all();

        return datatables()
            ->collection($age_ranges)
            ->addColumn('action',function ($item) {
                $edit_route = route('admin.settings.age_ranges.edit',$item);
                $delete_route = route('admin.settings.age_ranges.destroy',$item);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index()
    {
        $form = $this->getForm();
        //dd(AgeRange::all());
        return view("admin.age_ranges.index",compact('form'));
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

        AgeRange::create($data);

        return redirect()->route('admin.settings.age_ranges.index')->with('success','Groupe a été créé avec succès!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AgeRange $age_range
     * @return Application|Factory|View
     */
    public function edit(AgeRange $age_range)
    {
        $form = $this->getForm($age_range);
        return view('admin.age_ranges.index',compact('form'));
    }

    public function update(AgeRange $age_range)
    {
        $form = $this->getForm($age_range);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $age_range->update($data);
        return redirect()->route('admin.settings.age_ranges.index')->with('success','Le groupe a été mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(AgeRange $age_range)
    {
        $age_range->delete();
        return redirect()->back()->with("success", "Groupe a été supprimé!");
    }
}
