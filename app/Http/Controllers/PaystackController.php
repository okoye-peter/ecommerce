<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use Illuminate\Http\Request;
// use Ixudra\Curl\Facades\Curl;

class PaystackController extends Controller
{
    protected $id;
    public function pay(OrderQueue $order)
    {
        $this->id = $order->id;
        $curl = curl_init();

        $email = $order->user->email;
        $amount = (int)$order->price * 100 * 350;  //the amount in kobo.
    
        // url to go to after payment
        $callback_url = "127.0.0.1:8000/$order->id/payment_success";

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
                "authorization: Bearer sk_live_c91b7238f977c99de27e69dfbacb0b5f1ace1b54", //replace this with your own test key
                // "authorization: Bearer sk_test_d22a4eca3c627157c64468ab20f26c9bc5f9a56d", //replace this with your own test key
                "content-type: application/json",
                // "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            // there was an error contacting the Paystack API
            die('Curl returned error: ' . $err);
        }

        $tranx = json_decode($response, true);
        if (!$tranx['status']) {
            // there was an error from the API
            print_r('API returned error: ' . $tranx['message']);
        }

        header('Location: ' . $tranx['data']['authorization_url']);
    }

    public function paymentSuccess()
    {
        dd('waiting');
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
            echo "<h2>Thank you for making a purchase. Your file has bee sent your email.</h2>";
        }
    }

    public function transaction()
    {
        return view('transaction');
    }
}
