<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Credit;
use \App\Models\CreditsTransfersLog;

class TransferCreditsController extends Controller
{
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
        //dd($current_user->$credit_type,$request->input('sent_value'));
        if($current_user->$credit_type < $request->input('sent_value'))
            return redirect()->back()->with("error","Vous ne disposez pas d'assez de crédit pour le type de crédit selectionné");

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

    public function creditLogs()
    {
        $logs   = CreditsTransfersLog::all();
        return view('admin.credits.transferlogs',compact('logs'));
    }

    /*
     * Get credit data for datatable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function creditLogsData()
    {
        $logs = CreditsTransfersLog::with('sentBy','sentTo','credit')
                                    ->orderBy("created_at","desc")
                                    ->get();

        return datatables()
            ->collection($logs)
            ->addColumn('action',function ($logs) {
                $edit_route = route('banker.credits.edit',$logs);
                $delete_route = route('banker.credits.destroy',$logs);
                return view('layouts.back.datatables.actions-btn',compact('edit_route','delete_route'));
            })
            /* ->rawColumns(['action']) */
            ->make(true);
    }
}
