<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Upload;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;
use Illuminate\Support\Facades\Storage;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

use Srmklive\PayPal\Services\PayPal as PayPalClient;

class UserCreditPaymentCron extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UserCreditPayment:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $api_context;

    public function __construct()
    {
        parent::__construct();
        $this->api_context = new ApiContext(
            new OAuthTokenCredential(config('paypal.sandbox.client_id'), config('paypal.sandbox.client_secret'))
        );
//        $this->api_context->setConfig(config('paypal.settings'));
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {

        
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $order = $provider->createOrder([
            "intent"=> "CAPTURE",
            "application_context" => [
                "user_action"=>"PAY_NOW",
                "return_url"=>"https://example.com/",// Very important
                "cancel_url"=>"https://example.com/"
            ],
            "purchase_units"=> [
                 [
                    "payee" => [
                     "email_address"=> "sb-u6mev24339210@personal.example.com",   
                    ],
                    "amount"=> [
                        "currency_code"=> "USD",
                        "value"=> 20
                    ],
                     'description' => 'test'
                ]
            ],
        ]);
        $orderId = $order['id'];
//        dd($orderId);
        $result = $provider->capturePaymentOrder($orderId);
        dd($result);
        
//        $payer = new Payer();
//        $payer->setPaymentMethod("paypal");
//
//        
////        dd(config('paypal.sandbox.client_id'));
////        $apiContext = new ApiContext(
////        new OAuthTokenCredential(
////            $clientId,
////            $clientSecret
////        )
////    );
//        
////        $item_1 = new Item();
////        $item_1->setName('Item 1') /** item name **/
////            ->setCurrency('USD')
////            ->setQuantity(1)
////            ->setPrice(100); /** unit price **/
////        $itemList = new ItemList();
////        $itemList->setItems(array($item_1));
//        $amount = new Amount();
//        $amount->setCurrency('USD')
//            ->setTotal(100);
//
//        $payee = new Payee();
//
//        //this is the email id of the seller who will receive this amount
//
//        $payee->setEmail("sb-u6mev24339210@personal.example.com");
//        $transaction = new Transaction();
//        $transaction->setAmount($amount)
//            ->setDescription("Payment description")
//            ->setPayee($payee)
//            ->setInvoiceNumber(uniqid());
//        $redirectUrls = new RedirectUrls();
//        $redirectUrls->setReturnUrl(url('/'))
//            ->setCancelUrl(url('/'));
//        $payment = new Payment();
//        $payment->setIntent("sale")
//            ->setPayer($payer)
//            ->setRedirectUrls($redirectUrls)
//            ->setTransactions(array($transaction));
//        $request = clone $payment;
//        try {
//            //create payment object
//            $createdPayment = $payment->create($this->api_context);
//            
//            
//            //get payment details to get payer id so that payment can be executed and transferred to seller.
//            $paymentDetails = Payment::get($createdPayment->getId(), $this->api_context);
//            dd($paymentDetails->getPayer());
//            $execution = new PaymentExecution();
//            $execution->setPayerId($paymentDetails->getPayer());
//            $paymentResult = $paymentDetails->execute($execution,$this->api_context);
//        } catch (PayPal\Exception\PayPalConnectionException $e) {
//            //handle exception here
//            echo $e->getCode();
//echo $e->getData(); // Prints the detailed error message 
//dd($e);
////            dd($e->getMessage());
//        }
//        //Get redirect url
//        //The API response provides the url that you must redirect the buyer to. Retrieve the url from the $payment->getApprovalLink() method
//        $approvalUrl = $payment->getApprovalLink();
//
//        dd($approvalUrl);
        
        
    }

}
