<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function saveVueTransaction(Request $request)
    {
        $request;
        Transaction::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id,
            'transaction_token' => bin2hex(Str::random(15)),
            'paystack_reference' => $request->paystack_reference,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => $request->status,
        ]);
    }
    
    public function saveTransaction()
    {
        
    }
}
