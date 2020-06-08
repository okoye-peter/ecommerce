<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use App\User;
use App\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    /**
     * @param User
     * 
     * @return view & array
     */
    public function view(User $user)
    {
        $orders = $user->orderQueue->toArray();
        rsort($orders);
        return view('cart', compact('orders','user'));
    }

    public function removeFromCart(Product $order)
    {
        OrderQueue::where("product_id", $order->id)->where("user_id", auth()->user()->id)->delete();
        return back();
    }
}
