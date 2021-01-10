<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Forms\CreditPackForm;

use App\Models\CreditPack;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;

class CreditPackController extends Controller
{
    private $formBuilder;

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|banker']);
        $this->formBuilder = $formBuilder;
    }
    /*
     * Get credit pack data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function creditPackData()
    {
        $creditPack = \App\Models\CreditPack::all();
        return datatables()
            ->collection($creditPack)
            ->addColumn('action',function ($creditPack) {
                $edit_route = route('banker.credit_pack.edit',$creditPack);
                $delete_route = route('banker.credit_pack.destroy',$creditPack);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * @param Role|null $role
     * @return Form
     */
    private function getForm(?CreditPack $creditPack = null): Form
    {
        $creditPack = $creditPack ?: new CreditPack();
        return $this->formBuilder->create(CreditPackForm::class, [
            'model' => $creditPack
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new CreditPack();
        $form = $this->getForm();
        return view('admin.credit_packs.index',compact('form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $this->getForm();
        $data = $form->getFieldValues();

        $form->redirectIfNotValid();

        CreditPack::create($data);
        return redirect()->route('banker.credit_pack.index')->with('success','Le nouveau pack a été créé avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditPack $creditPack)
    {
        $form = $this->getForm($creditPack);
        return view('admin.credit_packs.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreditPack $creditPack)
    {
        $form = $this->getForm($creditPack);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();

        $creditPack->update($data);
        return redirect()->route('banker.credit_pack.index')->with('success','Le pack a été mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditPack $creditPack)
    {
        $creditPack->delete();
        return redirect()->back()->with('success','Le pack été supprimé avec succès!');
    }
}
