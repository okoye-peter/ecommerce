<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use App\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // public function saveVueTransaction(OrderQueue $order ,Request $request)
    // {
    //     Transaction::create([
    //         'product_id' => $order->product_id,
    //         'user_id' => $order->user_id,
    //         'order_ref' => bin2hex(Str::random(15)),
    //         'transaction_token' => $request->reference,
    //         'paystack_reference' => $request->trxref,
    //         'price' => $order->price,
    //         'quantity' => $order->quantity,
    //         'status' => $tranx->status,
    //     ]);
    // }
    
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
            $a = Transaction::create([
                'product_id' => $order->product_id,
                'user_id' => $order->user_id,
                'order_ref' => bin2hex(Str::random(15)),
                'transaction_token' => $request->reference,
                'paystack_reference' => $request->trxref,
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
            return redirect("/transactions/$order->user_id");
        }
    }
}
