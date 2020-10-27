<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use App\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use Ixudra\Curl\Facades\Curl;
class PaystackController extends Controller
{

    public function pay(OrderQueue $order)
    {
        $curl = curl_init();
        $email = $order->user->email;
        $amount = (int)$order->price * 100 ;  //the amount in kobo.
        $callback_url = route('paystack.payment.status', ['order' => $order->id]); // url to go to after payment 

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'amount' => $amount,
                'email' => $email,
                'callback_url' => $callback_url
            ]),
            CURLOPT_HTTPHEADER => [
                // "authorization: Bearer sk_live_c91b7238f977c99de27e69dfbacb0b5f1ace1b54", //replace this with your own test key
                "authorization: Bearer sk_test_d22a4eca3c627157c64468ab20f26c9bc5f9a56d", //replace this with your own test key
                "content-type: application/json",
                // "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) 
        {
            return back()->withErrors(['error' => "Sorry! Something went went wrong"]);
        }

        $tranx = json_decode($response, true);

        if (!$tranx['status']) 
        {
            // there was an error from the API
            // print_r('API returned error: ' . $tranx['message']);
            return back()->withErrors(['error' => "Sorry! Something went went wrong"]);
        }

        header("Location: " . $tranx['data']['authorization_url']);
        die();
    }

    public function saveTransaction(OrderQueue $order, Request $request)
    {
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {
            die('No reference supplied');
        }
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                // "authorization: Bearer sk_live_c91b7238f977c99de27e69dfbacb0b5f1ace1b54",
                "authorization: Bearer sk_test_d22a4eca3c627157c64468ab20f26c9bc5f9a56d",
                // "cache-control: no-cache"
            ],
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }
        $tranx = json_decode($response);
        if (!$tranx->status) {
            // there was an error from the API
            die('API returned error: ' . $tranx->message);
        }
        if ('success' == $tranx->data->status) {
            Transaction::create([
                'product_id' => $order->product_id,
                'user_id' => $order->user_id,
                'type' => "Paystack",
                'order_ref' => bin2hex(Str::random(15)),
                'gateway_ref' => $request->reference,
                'gateway_transaction' => $request->transaction,
                'price' => $order->price,
                'quantity' => $order->quantity,
                'status' => $tranx->status,
            ]);
            $order->delete();
            if ($request->ajax()) {
                return  response()->json([
                    'status' => 'success'
                ]);
            }
            return redirect("/user/transactions/".$request->id());
        }
    }

}
