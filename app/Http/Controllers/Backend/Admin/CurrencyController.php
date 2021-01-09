<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Credit;
use App\Models\User;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;

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
        $user = auth()->user();//We need the current user's id for the generated_by field

        return view('admin.currencies.index',compact('form','user'));
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
        $data = $request->validate([
            "name"    => "required | unique:currencies",
            "icons"   => "required",
        ]);
        $data['ref'] = Str::random(20);
        $data['created_by'] = auth()->user()->id;
        $currency = Currency::create($data);

        return redirect()
                ->route('banker.currencies.index')
                ->with('success','La monnaies a été créée avec succès!');
    }

    /**
     * Edit a resource in storage.
     *
     * @param  Currency id $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency = Currency::find($id);
        $form = $this->getForm($currency);
        $user = auth()->user();//We need the current user's id for the generated_by field

        return view('admin.currencies.index',compact('form','currency','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Currency $currency, Request $request)
    {

        $data = $request->validate([
            "name"    => "required | unique:currencies,name,".$currency->id,
            "icons"   => "required",
        ]);
        $data['ref'] = Str::random(20);
        $data['created_by'] = auth()->user()->id;
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
        return view("admin.currencies.accounts", compact('currencies', 'user'));
    }

    /**
     * 
     * Render the form to generate a currency
     */
    public function transfer(Currency $currency)
    {
        $user = auth()->user();
        //We need users with the role admin or super-admin
        $users = User::whereHas("roles", function($q){ $q->where("name", "admin")
                     ->orWhere('name','super-admin'); })
                     ->pluck('name','id');
        //We need the data for the picked currency for the current user
        $currency = $user->currencies()->wherePivot('currency_id',$user->id)->first();
        return view('admin.currencies.transfering', compact("currency","user","users"));
    }

    public function transfering(Request $request, Currency $currency)
    {
        $data = $request->validate([
            "send_by" => "required | integer",
            "send_to" => "required | integer",
            "credit_type" => "required | integer",
            "currency_id" => "required",
            "sent_value" => "required | integer"
        ]);

        $sender = $currency->getUserCurrency($data['send_by'],$data['currency_id']);
        $currency_type = $data['credit_type'] > 0 ? 'paid_currency' : 'free_currency';
        //Check if sender have enough currency to send
        if($sender->pivot->$currency_type < $data['sent_value'])
            return redirect()
                    ->back()
                    ->with("error", "Vous n'avez pas assez pour faire le transfert.");

        $recipient = $currency->setUserCurrency($data['send_to'],$data['currency_id']);
        $currency->transfering($sender, $recipient, $currency_type, $data['sent_value']);

        //We need the initial amounts of each account for the logs.s
        $send_initial_amount = intval($sender->pivot->$currency_type) ;
        $recipient_initial_amount = intval($recipient->pivot->$currency_type) ;
        $logs = [
            'ref' => Str::random(20),
            'sent_by' => $data['send_by'],
            'sent_to' => $data['send_to'],
            'credit_id' => $data['currency_id'],
            'credit_type' => $data['credit_type'],
            'sender_initial_credit' => $send_initial_amount,
            'recipient_initial_credit' => $recipient_initial_amount,
            'sent_value' => $data['sent_value'],
            'sender_new_credit' => $send_initial_amount - intval($data['sent_value']),
            'recipient_new_credit' => $recipient_initial_amount + intval($data['sent_value']),
            'transfer_status' => 1
        ];
        //Then we save in the log
        \App\Models\CreditsTransfersLog::create($logs);

        return redirect()
                ->back()
                ->with("success", "Montant tensféré!");
        //dd($sender);
    }
}
