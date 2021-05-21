<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Currency;
use \App\Models\CreditsTransfersLog;
use Illuminate\Support\Str;

class TransferCreditsController extends Controller
{
    /**
     * 
     * old method use to transfer credit (not currency)
     */
    public function transferCredits(Request $request)
    {
        $current_user   = auth()->user();//We need the current user's id for the generated_by field
        $users          = User::where('id', '!=', $current_user->id)->pluck('name','id');
        $credit_types   = ['Free credits', 'Paid credit'];

        //Check if the recipient is not banned
        $recipient = User::find($request->input("send_to"));
        if(!$recipient)
            return view('admin.credits.transfer',compact('users','current_user'))->with('error',"Une erreur c'est produite");

        if(@$recipient->profile_status > 1)
            return view('admin.credits.transfer',compact('users','current_user'))->with('error','Le compte de ce membre à été bloqué ou est banni!');

        $credit_type = intval($request->input('credit_type')) === 0 ? "free_credits" : "paid_credits";
        //Check if sender has enough of type credit
        if($current_user->$credit_type < $request->input('sent_value'))
            return redirect()->back()->with("error","Vous ne disposez pas d'assez de reserve pour le type de crédit selectionné");

        //We need the initial value of sender and recipient to save them in logs table
        $sender_initial_credit      = $current_user->$credit_type;
        $recipient_initial_credit   = $recipient->$credit_type;

        //If sender is the banker
        if($current_user->hasRole('banker')){
            //We need to gather all the credits incase the sent_value is too high.
            $credits = Credit::where("value", ">", 0)
                             ->where("credit_type",$request->input('credit_type'))
                             ->orderBy('value', 'desc')
                             ->get();
            $sent_value = intval($request->input("sent_value"));
            foreach($credits as $credit)
            {
                if($credit->value <= $sent_value){
                    $credit->value = 0;
                    $sent_value -= $credit->value;
                } else {
                    $credit->value = $credit->value - $sent_value;
                    $sent_value = 0;
                }
                $credit->save();
                $credit->updateBankerCredit();
                if ($sent_value <= 0) 
                    break; 
            }

        } elseif($current_user->hasRole('super-admin')){
            $current_user->$credit_type = $current_user->$credit_type - $request->input('sent_value');
        } else {
            $current_user->paid_credits = $current_user->paid_credits - $request->input('sent_value');
        }
        $recipient->$credit_type = intval($recipient->$credit_type) + $request->input('sent_value');
        $current_user->save();
        $recipient->save();

        //Now we save the transfer in the logs table
        $logs = [
                'ref'           => \Illuminate\Support\Str::random(20),
                'sent_by'       => $current_user->id,
                'sent_to'       => $request->input("send_to"),
                'credit_type'   => $request->input("credit_type"),
                'sender_initial_credit'     => $sender_initial_credit,
                'recipient_initial_credit'  => $recipient_initial_credit,
                'sent_value'    => $request->input("sent_value"),
                'sender_new_credit'         => $sender_initial_credit - $request->input("sent_value"),
                'recipient_new_credit'      => $recipient->$credit_type,
                'transfer_status'           => 1
                ];
        CreditsTransfersLog::firstOrCreate($logs);
        return redirect()->back()->with("success", "Crédit transéré avec succès!");
    }

    /**
     * transfering : method that handle currency transfering
     */
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
        $currency       = Currency::find($data['currency_id']);
        //We check if the sender is the current user 
        if(intval(@$data['send_by']) !== auth()->user()->id){
            return redirect()
                    ->back()
                    ->with("error", "Une erreur s'est produite.");
        }
        $sender = $currency->getUserCurrency(@$data['send_by']);
        if( $sender == null ){
            return redirect()
                    ->back()
                    ->with("error", "Une erreur s'est produite.");
        }
        //We make sure vendeur , chef vendeur and member can only send paid currency type
        if($sender->hasAnyRole(['admin','super-admin','banquier'])){
            $currency_type  = intval($data['credit_type']) > 0 ? 'paid_currency' : 'free_currency';
        } else {
            $currency_type  = 'paid_currency';
        }
        //dd($currency_type);
        $sender = $currency->getUserCurrency($data['send_by']);
        //Check if sender have enough currency to send
        if($sender->pivot->$currency_type < $data['sent_value']){
            return redirect()
                    ->back()
                    ->with("error", "Vous n'avez pas assez de reserve pour faire le transfert.<br>");
        }
        //Get set recipient current currency status
        $recipient = $currency->setUserCurrency($data['send_to']);
        //Lets make sure sender and recipient are not the same
        if($sender->id == $recipient->id){
            return redirect()
                    ->back()
                    ->with("error", "Une erreur s'est produite.");
        }
        
        //We need the initial amounts of each account for the logs.
        $send_initial_amount = intval($sender->pivot->$currency_type) ;
        $recipient_initial_amount = intval($recipient->pivot->$currency_type) ;

        $currency->transfering($sender, $recipient, $data['credit_type'], $data['sent_value']);

        $logs = [
            'ref' => Str::random(12),
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
        $type = intval($data['credit_type'] === 1)?"payant" : "gratuit";
        return redirect()
                ->back()
                ->with("success", $data['sent_value']." $currency->name de type $type ont été tensférés à $recipient->prenom $recipient->name !");
    }

    public function currencyLogs()
    {
        $logs = CreditsTransfersLog::with('sentBy','sentTo','credit')
                                    ->orderBy("created_at","desc")
                                    ->get();
        return view('admin.credits.transferlogs',compact('logs'));
    }

    /*
     * Get credit data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function currencyLogsData(Request $request)
    {
        $logs = CreditsTransfersLog::with('sentBy','sentTo','credit')
                                    ->orderBy("created_at","desc")
                                    ->get();

        return datatables()
            ->collection($logs)
            /* ->addColumn('action',function ($logs) {
                $edit_route = route('banker.credits.edit',$logs);
                $delete_route = route('banker.credits.destroy',$logs);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            }) */
            /* ->rawColumns(['action']) */
            ->make(true);
    }

    public function singleCurrencyLogs($id)
    {
        $currency   = Currency::find($id);
        return view('admin.currencies.singleCurrencyTransferlogs',compact('currency'));
    }

    public function singleCurrencyLogsData($id)
    {

        $currency = Currency::with('transferslog')
                        ->where('id',$id)
                        ->orderBy("created_at","desc")
                        ->first();
        $logs = $currency->transferslog->all();
        $logs = CreditsTransfersLog::with('sentBy','sentTo','credit')
                                    ->orderBy("created_at","desc")
                                    ->where('credit_id', $id)
                                    ->get();

        return datatables()
            ->collection($logs)
            /* ->addColumn('action',function ($logs) {
                $edit_route = route('banker.credits.edit',$logs);
                $delete_route = route('banker.credits.destroy',$logs);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            }) */
            /* ->rawColumns(['action']) */
            ->make(true);
    }
}
