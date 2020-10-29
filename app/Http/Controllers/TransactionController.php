<?php

namespace App\Http\Controllers;

use App\User;
use App\OrderQueue;
use App\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TransactionController extends Controller
{    
    public function transaction(User $user){
        $transactions =  Transaction::where('user_id', $user->id)->with('product')->get();
        return view('transaction', compact('transactions'));
    }
}
