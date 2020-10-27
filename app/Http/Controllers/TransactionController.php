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
        $transactions =  $user->transactions;
        return view('transaction', compact('transactions'));
    }
}
