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
//        $mergeData = array_merge($data,['status' => TransactionStatus::PENDING, 'vendor_order_id' => $order['id']]);
//        DB::beginTransaction();
//        Order::create($mergeData);
//        DB::commit();
        return response()->json($order);


        //return redirect($order['links'][1]['href'])->send();
       // echo('Create working');
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

//            $result = $result->purchase_units[0]->payments->captures[0];
        try {
//            DB::beginTransaction();
//            if($result['status'] === "COMPLETED"){
//                $transaction = new Transaction;
//                $transaction->vendor_payment_id = $orderId;
//                $transaction->payment_gateway_id  = $data['payment_gateway_id'];
//                $transaction->user_id   = $data['user_id'];
//                $transaction->status   = TransactionStatus::COMPLETED;
//                $transaction->save();
//                $order = Order::where('vendor_order_id', $orderId)->first();
//                $order->transaction_id = $transaction->id;
//                $order->status = TransactionStatus::COMPLETED;
//                $order->save();
//                DB::commit();
//            }
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return response()->json($result);
    }

    
}
