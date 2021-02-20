<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
    public function payment(Request $request) {
        //check if the price is set
        $price = session("price",null);
        if($price === null){
            return redirect()->route('welcome')->with("error", "Votre achat a été interrompu en raison d'un dysfonctionnement interne. Veuillez réessayer. Et si cela persiste contactez-nous.");
        }
        //Check if the user datails are available
        $user = User::find(@$request->user_id);
        if(!$user){
            return redirect()->route('welcome')->with("error", "Nous avons du mal à associer votre profil à l'achat. Assurez-vous que vous êtes connecté, veuillez");
        }

        $title = $request->form_payment_title;

        $gateway = new \Braintree\Gateway([
            'environment'   => config('services.braintree.environment'),
            'merchantId'    => config('services.braintree.merchantId'),
            'publicKey'     => config('services.braintree.publicKey'),
            'privateKey'    => config('services.braintree.privateKey')
        ]);
        $token = $gateway->ClientToken()->generate();

        return view('payments.payment_page', [ 'token' => $token ,"title" => $title, "price" => $price, "user" => $user]);
    }

    /**
     * 
    */
    public function checkout(Request $request) {
        //check if the price is set
        $price = session("price",null);
        if($price === null){
            return redirect()->route('welcome')->with("error", "Votre achat a été interrompu en raison d'un dysfonctionnement interne. Veuillez réessayer. Et si cela persiste contactez-nous.");
        }
        $data = $request->validate([
            'user_id' => "required"
        ]);
        //Check if the user datails are available
        $user = User::find(@$request->user_id);
        if(!$user){
            return redirect()->route('welcome')->with("error", "Nous avons du mal à associer votre profil à l'achat. Assurez-vous que vous êtes connecté, veuillez");
        }
        $gateway = new \Braintree\Gateway([
            'environment'   => config('services.braintree.environment'),
            'merchantId'    => config('services.braintree.merchantId'),
            'publicKey'     => config('services.braintree.publicKey'),
            'privateKey'    => config('services.braintree.privateKey')
        ]);

        $nonce = $request->payment_method_nonce;
        $result = $gateway->transaction()->sale([
            'amount' => $price,
            'paymentMethodNonce' => $nonce,
            'customer' => [
                'firstName' => $user->prenom,
                'lastName'  => $user->name,
                'email'     => $user->email,
            ],
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            $transaction = $result->transaction;
            // header("Location: transaction.php?id=" . $transaction->id);
            //return "Well done";
            return view('payments/success_payment',['transaction' => $transaction])/* ->with('success_message', 'Transaction successful. The ID is:'. $transaction->id) */;
        } else {
            $errorString = "";

            foreach ($result->errors->deepAll() as $error) {
                $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
            }
            dd($errorString);
            // $_SESSION["errors"] = $errorString;
            // header("Location: index.php");
            return back()->withErrors('An error occurred with the message: '.$result->message);
        }
    }
}
