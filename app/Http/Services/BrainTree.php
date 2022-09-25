<?php

namespace App\Http\Services;

use App\Models\PaymentLogs;
use Illuminate\Http\Request;
use Braintree as PaymentBrainTree;
use Illuminate\Support\Facades\Crypt;

class BrainTree
{



    public static function GetConfiguration()
    {
        return new PaymentBrainTree\Gateway([
            'environment' => config('app.BT_ENVIRONMENT'),
            'merchantId' => config('app.BT_MERCHANT_ID'),
            'publicKey' => config('app.BT_PUBLIC_KEY'),
            'privateKey' => config('app.BT_PRIVATE_KEY')
        ]);
    }
    public static function init($parameters = [])
    {
        $params = [];



        $params["token"] = self::GetConfiguration()->ClientToken()->generate();

        return $params;
    }

    public static function checkout(Request $request)
    {
        $response = ["status" => false, "message" => "Something went wrong"];
        if ($request->has("amount") && $request->has("payment_method_nonce")) {
            $config = self::GetConfiguration();
            $result = $config->transaction()->sale([
                'amount' => $request->amount,
                'paymentMethodNonce' => $request->payment_method_nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);
            if ($request->has("payment_id")) {
                PaymentLogs::where("payment_id", Crypt::decrypt($request->payment_id))->update(["response_datetime" => date("Y-m-d H:i:s"), "response" => json_encode($result)]);
            }
            if ($result->success && !is_null($result->transaction)) {
                $response = ["status" => true, "message" => "Transaction Successfull", "id" => $result->transaction->id, "amount" => $result->transaction->amount];
            } else {
                $response = ["status" => false, "message" => "Transaction Failed", "id" => $result->transaction->id, "amount" => $result->transaction->amount];
            }
        }
        return  $response;
    }
}
