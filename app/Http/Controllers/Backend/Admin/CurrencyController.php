<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Credit;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class CurrencyController extends Controller
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
    public function currenciesData()
    {
        $currency = Currency::all();
        return datatables()
            ->collection($currency)
            ->addColumn('action',function ($currency) {
                $edit_route = route('banker.currencies.edit',$currency);
                $delete_route = route('banker.currencies.destroy',$currency);
                $another_actions = [
                    [
                        'name' => 'Générer',
                        'route' => route('banker.currencies.generate',$currency)
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
    private function getForm(?Currency $currency = null): Form
    {
        $currency = $currency ?: new Currency();
        return $this->formBuilder->create(\App\Forms\CurrencyForm::class, [
            'model' => $currency
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model  = new Currency();
        $form   = $this->getForm();
        $current_user = auth()->user();//We need the current user's id for the generated_by field

        $free_credits = $model->totalFreeCredits;
        $paid_credits = $model->totalPaidCredits;

        return view('admin.currencies.index',compact('form','current_user','paid_credits','free_credits'));
    }

    public function show(Currency $currencies){}
    public function create(){}

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
        $currency = Currency::create($data);

        return redirect()
                ->route('banker.currencies.index')
                ->with('success','La monnaies a été créée avec succès!');
    }
    public function edit($id)
    {
        $currencies = Currency::find($id);
        $form = $this->getForm($currencies);
        return view('admin.currencies.index',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Currency $currency)
    {
        $form = $this->getForm($currency);
        $data = $form->getFieldValues();
        $form->redirectIfNotValid();
        $currency->update($data);
        return redirect()
                ->route('banker.currencies.index')
                ->with('success','La monnaie a été mise à jour avec succès!');
    }
    /**
     * 
     * Deleting a line
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();
        return redirect()->back()->with('success','La monnaie a été supprimée avec succès!');
    }

    /**
     * 
     * Render the form to generate a currency
     */
    public function generate(Currency $currency)
    {
        $user = auth()->user();
        return view('admin.currencies.generate', compact("currency","user"));
    }

    /**
     * 
     */
    public function generator(Request $request)
    {
        $data = $request->validate([
            "user_id"       => "required | integer",
            "currency_id"   => "required | integer",
            "currency_type" => "required | integer",
            "amount"        => "required | integer"
        ]);

        $currency       = Currency::find($data['currency_id']);
        $sync           = $currency->users()->sync([$data['user_id']]);
        $currency_type  = $data['currency_type'] > 0 ? "paid_currency" : "free_currency";

        $currency->users[0]->pivot->$currency_type += $data["amount"];
        $currency->users[0]->pivot->save();

        return redirect()
                ->route('banker.currencies.accounts')
                ->with('success',ucfirst($currency->name )." généré(e) avec succès");
    }

    public function accounts()
    {
        $user = auth()->user();
        $currencies = $user->currencies;
        // $currencies = Currency::where
        return view("admin.currencies.accounts", compact('currencies', 'user'));
    }
}
