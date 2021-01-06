<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;

use App\Models\Credit;
use App\Forms\CreditForm;
use App\Models\User;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Yajra\Datatables\Datatables;


class CreditsController extends Controller
{

    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|banker'],['except' => ['creditsTransfer']]);
        $this->formBuilder = $formBuilder;
    }

    /*
     * Get credit data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function creditData()
    {
        $credit = Credit::all();
        return datatables()
            ->collection($credit)
            ->addColumn('action',function ($credit) {
                $edit_route = route('banker.credits.edit',$credit);
                $delete_route = route('banker.credits.destroy',$credit);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getUsersLists(Request $request)
    {
        $users = User::select('id','name')
                    ->where('id', '!=', auth()->id())
                    ->where("name","LIKE","%{$request->term}%")
                    ->get();
        return response()->json($users);
    }
    public function creditsTransfer(Request $request)
    {
        dd($request->inputs);
    }
    /**
     * @param Role|null $role
     * @return Form
     */
    private function getForm(?Credit $credit = null): Form
    {
        $credit = $credit ?: new Credit();
        return $this->formBuilder->create(CreditForm::class, [
            'model' => $credit
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model  = new Credit();
        $form   = $this->getForm();
        $current_user = auth()->user();//We need the current user's id for the generated_by field
        $users  = User::where('id', '!=', $current_user->id)->pluck('name','id');

        $free_credits = $model->totalFreeCredits;
        $paid_credits = $model->totalPaidCredits;

        return view('admin.credits.index',compact('form','current_user','users','paid_credits','free_credits'));
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
        //$credit = new Credit();

        $form->redirectIfNotValid();
        /* $credit_type = intval($request->input('credit_type')) === 0 ? "free_credits" : "paid_credits";
        auth()->user()->increment("$credit_type", $request->input("value")); */
        $credit = Credit::create($data);
        $credit->updateBankerCredit();

        return redirect()->route('banker.credits.index')->with('success','Le nouveau pack a été créé avec succès!');
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
    public function edit(Credit $credit)
    {
        $form = $this->getForm($credit);
        $current_user = auth()->user();//We need the current user's id for the generated_by field
        $users  = User::where('id', '!=', $current_user->id)->pluck('name','id');

        $free_credits = $credit->totalFreeCredits;
        $paid_credits = $credit->totalPaidCredits;

        return view('admin.credits.index',compact('form','current_user','users','free_credits','paid_credits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Credit $credit)
    {
        $form = $this->getForm($credit);
        $data = $form->getFieldValues();
        //dd($data);
        $form->redirectIfNotValid();

        $credit->update($data);
        $credit->updateBankerCredit();
        return redirect()->route('banker.credits.index')->with('success','Le pack a été mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credit $credit)
    {
        $credit->delete();
        $credit->updateBankerCredit();
        return redirect()->back()->with('success','Le pack été supprimé avec succès!');
    }
}
