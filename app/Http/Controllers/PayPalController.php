<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Crypt;
use App\Models\AdvertPost;

class PayPalController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paymentIndex($id) {
        $post_id = Crypt::decrypt($id);
        $advertPost = AdvertPost::where('post_id', $post_id)->first();
        $amount = $advertPost->your_budget;
        return view('paypal-index', compact('post_id','amount'));
    }

      public function create(Request $request)
    {
        $provider = new PayPalClient;
        $data = json_decode($request->getContent(), true);
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $order = $provider->createOrder([
            "intent"=> "CAPTURE",
            "purchase_units"=> [
                 [
                    "amount"=> [
                        "currency_code"=> "USD",
                        "value"=> $data['amount']
                    ],
                     'description' => 'test'
                ]
            ],
        ]);
        return response()->json($order);
    }

    public function capture(Request $request)
    {
        $provider = new PayPalClient;
        $data = json_decode($request->getContent(), true);
        $orderId = $data['orderId'];
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $result = $provider->capturePaymentOrder($orderId);
        try {
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return response()->json($result);
    }

    
}
