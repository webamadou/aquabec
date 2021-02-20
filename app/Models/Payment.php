<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Braintree\Gateway;

class Payment extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function purchassable()
    {
        return $this->morphTo();
    }

    public static function buildPaymentToken()
    {
        $gateway = new Gateway([
            'environment'   => config('services.braintree.environment'),
            'merchantId'    => config('services.braintree.merchantId'),
            'publicKey'     => config('services.braintree.publicKey'),
            'privateKey'    => config('services.braintree.privateKey')
        ]);

        return $gateway->ClientToken()->generate();
    }

    public static function checkSession()
    {
        if(session('token') === null || session('price') === null || session('token') === null || session('user_details') === null){
            return false;
        }
        return true;
    }
    /**
     * Process the Braintree checkout 
     */
    public static function checkout($nonce)
    {
        if(!self::checkSession()){
            return false;
        }
        $response = [];
        $gateway = new Gateway([
            'environment'   => config('services.braintree.environment'),
            'merchantId'    => config('services.braintree.merchantId'),
            'publicKey'     => config('services.braintree.publicKey'),
            'privateKey'    => config('services.braintree.privateKey')
        ]);

        $result = $gateway->transaction()->sale([
                    'amount'                => session('price'),
                    'paymentMethodNonce'    => $nonce,
                    'customer' => [
                        'firstName' => session('user_details')['prenom'],
                        'lastName'  => session('user_details')['name'],
                        'email'     => session('user_details')['email'],
                    ],
                    'options' => [
                        'submitForSettlement' => true
                    ]
                ]);
        /* $transaction = $result->transaction;
        dd($result, @$result->message, @$transaction->updatedAt, @$transaction->creditCard['cardType'], @$transaction->creditCard['last4'],@$transaction->paypal); */
        if ($result->success) {
            $response = ["status" => "SUCCESS","transaction" => $result->transaction, "messages" => null];
        } else {
            $errorString = "";
            foreach ($result->errors->deepAll() as $error) {
                $errorString .= '<div class="alert alert-danger">Error: ' . $error->code . ': ' . $error->message . '</div>';
            }

            $response = ["status" => "ERROR","transaction" => [],"messages" => $errorString];
        }

        return $response;
    }
}
