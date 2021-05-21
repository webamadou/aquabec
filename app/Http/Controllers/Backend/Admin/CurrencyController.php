<?php
namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\Credit;
use App\Models\User;
use App\Http\Requests\updateCurrencyRequest;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Str;

class CurrencyController extends Controller
{
    
    public function __construct(FormBuilder $formBuilder)
    {
        $this->middleware(['auth','verified','role:super-admin|banker|banquier'],['except' => ['creditsTransfer','purchase','purchasing','purchasing_checkout','updatePricesList']]);
        $this->formBuilder = $formBuilder;
    }

    /*
     * Get credit data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currenciesData()
    {
        $currency = Currency::where('status','<=',1)->get();
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
        $currencies = Currency::where('status','<=',1)->get();
        $user = auth()->user();//We need the current user's id for the generated_by field

        return view('admin.currencies.index',compact('form','user','currencies'));
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
            "name"    => "required|unique:currencies",
            "icons"   => "required|unique:currencies|max:60",
            "description" => "nullable"
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
        $currencies = Currency::where('status','<=',1)->get();
        $user = auth()->user();//We need the current user's id for the generated_by field

        return view('admin.currencies.index',compact('form','currency','user','currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Currency $currency, updateCurrencyRequest $request)
    {
        $data = $request->validated();
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
        if($currency->id == 1){
            return redirect()->back()->with('error','Cette monnaie ne peut être supprimé!');
        }
        //$currency->delete();
        $currency->status = 4;//When setting the status field to 4, we are making a logical suppression
        $currency->save();
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
        if($currency == null)
            return false;
        $currency       = $currency->setUserCurrency($data['user_id']);//get the relation user -> currency
        $currency_type  = $data['currency_type'] > 0 ? "paid_currency" : "free_currency";//We picj the corresponding type currency
        //then we update and save the value
        $currency->pivot->$currency_type += $data["amount"];
        $currency->pivot->save();

        return redirect()
                ->route('banker.currencies.accounts')
                ->with('success',ucfirst($currency->name )." généré(e) avec succès");
    }

    public function accounts()
    {
        $user = auth()->user();
        $currencies = $user->currencies()
                           ->where('status','<=',1)
                           ->get();

        return view("admin.currencies.accounts", compact('currencies'));
    }

    /**
     * 
     * Render the form to generate a currency
     */
    public function transfer(Currency $currency)
    {
        if(!$currency)
            return route("banker.currencies.accounts");
        $user = auth()->user();
        //We need users with the role admin or super-admin
        /* $users = User::whereHas("roles", function($q){ $q->where("name", "admin")
                     ->orWhere('name','super-admin'); })
                     ->pluck('name','id'); */
        $users = User::where("profile_status", '<', 2)
                        ->select('prenom','username','name','id')
                        ->orderby('id','asc')
                        ->get();
        //We need the current user's wallet valur for the picked currency
        $currency = $user->currencies()->wherePivot('currency_id',$currency->id)->first();

        return view('admin.currencies.transfering', compact("currency","user","users"));
    }

    public function transfering(Request $request)
    {
        $data = $request->validate([
            "send_by" => "required | integer",
            "send_to" => "required | integer",
            "credit_type" => "required | integer",
            "currency_id" => "required",
            "sent_value" => "required | integer",
            "notes" => "nullable"
        ]);
        $currency = Currency::find($data['currency_id']);
        $sender = $currency->getUserCurrency($data['send_by']);
        $currency_type = $data['credit_type'] > 0 ? 'paid_currency' : 'free_currency';
        if($sender == null)
            return redirect()
                    ->route('banker.currencies.accounts')
                    ->with("error", "Une erreur s'est produite.");
            
        //Check if sender have enough currency to send
        if($sender->pivot->$currency_type < $data['sent_value'])
            return redirect()
                    ->back()
                    ->with("error", "Vous n'avez pas assez pour faire le transfert.");

        $recipient = $currency->setUserCurrency($data['send_to']);
        
        //We need the initial amounts of each account for the logs.s
        $send_initial_amount = intval($sender->pivot->$currency_type) ;
        $recipient_initial_amount = intval($recipient->pivot->$currency_type) ;
        
        //dd($data['send_to'],$data['currency_id'],$recipient);
        $currency->transfering($sender, $recipient, $data['credit_type'], $data['sent_value']);

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
            'notes' => $data['notes'],
            'transfer_status' => 1
        ];
        //Then we save in the log
        $save = \App\Models\CreditsTransfersLog::create($logs);

        return redirect()
                ->back()
                ->with("success", "Montant tensféré!");
        //dd($sender);
    }
    /**
     * Method called from ajax to update the price when purchase currency
     */
    public function updatePricesList(Request $request)
    {
        $currency_id = $request->id;
        $user = auth()->user();
        if($currency_id == 1){
            $role = $user->roles->first();
        } else{
            $role = $user->getRoleFromCurrency($currency_id);
        }

        $price_options = $user->buildPricesOptions($role->id);

        return response()->json($price_options);
    }
    /**
     * display the form to purchase a currency
     */
    public function purchase()
    {
        $current_user = auth()->user();
        $currencies = $current_user->currencies;
        if(!empty($current_user->roles->all())){
            $price_options = $current_user->buildPricesOptions(@$current_user->roles->first()->id);
        } else {
            $current_user->assignRole('membre');
            $price_options = $current_user->buildPricesOptions(@$current_user->roles->first()->id);
        }
        //dd($current_user->roles->first()->name, $currencies,$price_options);
        return view("user.currencies.purchase_currency", compact('currencies','price_options'));
    }

    public function purchasing(Request $request)
    {
        $data = $request->validate([
                   'price' => 'required|integer|max:20',
                   'currency_id' => 'required' 
                ]);
        $currency = Currency::find($data['currency_id']);
        $user   = auth()->user();
        //If the currency is 1 we take the first role of the user else we get the role from given currency.
        $role   = intval($data['currency_id']) === 1 ? $user->roles->first() : $user->getRoleFromCurrency($data['currency_id']);
        //We get the price details from the given price
        $currency_prices   = $role->credit_prices()->where('price',$data['price'])->first();

        //dd( $currency_prices->price,$data['currency_id'], $user->getRoleFromCurrency($data['currency_id'])->credit_prices() );
        $title  = "Vous allez acheter ".$currency_prices->credit_amount." $currency->name à $".$data['price'].".00";

        $token  = \App\Models\Payment::buildPaymentToken();
        //We populare the sessions
        session([
            "token" => $token,
            "price" => $currency_prices->price,
            "amount" => $currency_prices->credit_amount,
            "product_name" => "currency",
            "product_id" => $data['currency_id'],
            "user_details" => [
                        'user_id'   => $user->id,
                        'prenom'    => $user->prenom,
                        'name'      => $user->name,
                        'email'     => $user->email
                    ],
            "form_action" => route('checkout_purchase_currency'),
            "payment_title" => $title
            ]);


        return view('payments.payment_page');
    }

    public function purchasing_checkout(Request $request)
    {
        if(!session('token')){
			dd("no token");
            return redirect()->route("home") ;
        }
        //Check if given user exist
        $currency = Currency::find(session('product_id'));
        $buyer = $currency->setUserCurrency(session('user_details')['user_id']);
        
        if(!$buyer || !$currency){
            return redirect()->route('home')->with("error", "Nous avons du mal à associer votre profil à l'achat. Assurez-vous que vous êtes connecté");
        }

        //For now we will get the credit from the super-admin. Later it should go to the user's godfarther, if any.
        $godfather  = $currency->setUserCurrency(1);
        //We get the nonce generated by the braitree gateaway and pass it to the Payment::checkout method
        $amount     = session("amount");
        $note       = "Achat de $amount $currency->name à ".session("price")." CAD";
        //We check all is correct with data about to be saved
        if(!$currency->transferCheckings($godfather, $buyer, 1, $amount)){
			 return redirect()->route('home')->with("Une erreur s'est produite lors du traitement. Veuillez réessayer.");
        }

        $nonce      = $request->payment_method_nonce;
        //We call the checkout method to process payment
        $payment    = \App\Models\Payment::checkout($nonce);
        if ($payment['status'] === 'SUCCESS') {
            $wetransfer = $currency->saveTransfer($godfather, $buyer, 1, $amount,$note);

            $message = "Nous avons bien reçu votre transaction. \nVotre portfeuille a été mis à jour.\n";
            //We send the email notification to the user
            $buyer->notify((new \App\Notifications\PaymentReceived($buyer, $message))->delay(now()->addMinutes(10)));
            //We now need to save the transaction to the table before return
            $transaction = $payment["transaction"];
            //If we get the paypal index , user paid with paypal. If not we get the card type and the last four digits
            $payment_method = isset($transaction->paypal)?"Paypal-".$transaction->paypal['payerEmail']:$transaction->creditCard['cardType']."-".$transaction->creditCard['last4'];
            \App\Models\Payment::create([
                "user_id" => $buyer->id,
                "payment_method" => $payment_method,
                "payment_id" => $transaction->id,
                "purchassable_id" => $currency->id,
                "purchassable_type" => "App\Models\Currency",
                "amount" => session("price"),
            ]);
            //And we destroy the session
            session()->forget(["token","user_details"]);

            return view('payments/success_payment',['message' => $message]);
        } else {
            $errors = $payment['messages'];
            return view("payments/failed_payment",compact("errors"));
        }
    }
}
