<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use Illuminate\Http\Request;
// use Ixudra\Curl\Facades\Curl;
class PaystackController extends Controller
{
    public function links($link)
    {
        header("Location: " . $link);
        die();
    }

    public function pay(OrderQueue $order)
    {
        $curl = curl_init();
        $email = $order->user->email;
        $amount = (int)$order->price * 100 * 350;  //the amount in kobo.
        $callback_url = route('payment.status', ['order' => $order->id]); // url to go to after payment 

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

        $this->links($tranx['data']['authorization_url']);
    }

    public function transaction()
    {
        return view('transaction');
    }
}
