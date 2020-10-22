<?php

namespace App\Http\Controllers;

use App\User;
use App\Product;
use App\OrderQueue;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param User
     * 
     * @return view & array
     */
    public function index(User $user)
    {
        $orders = $user->orderQueue()->with('product')->latest()->get();
        return view('cart', compact('orders', 'user'));
    }

    /**
     * @param Product
     * 
     * @return integer
     */
    public function store(Product $product)
    {
        if ($product->id) {
            $status = false;
            $a = auth()->user();

            foreach ($a->orderQueue as $key => $value) {
                if ($value->product_id == $product->id) {
                    $status = true;
                }
            }

            if (!$status) {
                $a->orderQueue()->create([
                    'price' => $product->price,
                    'product_id' => $product->id
                ]);
                return count($a->orderQueue) + 1;
            }
            return count($a->orderQueue);
        }
        
    }

    /**
     * @param OrderQueue
     * 
     * @return array
     */
    public function increaseProductOrderQuantity(OrderQueue $order)
    {
        if ($order) {
            $quantity = ++$order->quantity;
            $price = $order->product->price * $quantity;
            $data = ["quantity" => $quantity, "price" => $price];
            $order->update($data);
            return $data;
        }
        return response([
            'error' => 'Order id not found'
        ]);
    }

    /**
     * @param OrderQueue
     * 
     * @return array
     */
     public function decreaseProductOrderQuantity(OrderQueue $order)
    {

        if ($order) {
            if ($order->quantity > 1) {
                $quantity = --$order->quantity;
                $price = $order->product->price * $quantity;
                $data = ["quantity" => $quantity, "price" => $price];
                $order->update($data);
                return $data;
            }
            $data = ["quantity" => $order->quantity, "price" => $order->price];
            return $data;
        }
        return response([
            'error' => 'Order id not found'
        ]);
    }

    /**
     * @param OrderQueue
     * 
     * @return array
     */
    public function setProductOrderQuantity(OrderQueue $order, Request $request)
    {
        if ($order) {
            if ($request->quantity > 0) {
                $price = $order->product->price * $request->quantity;
                $data = ["quantity" => $request->quantity, "price" => $price];
                $order->update($data);
                return $data;
            }
            $data = ["quantity" => $order->quantity, "price" => $order->price];
            $order->update($data);
            return $data;
        }
        return response([
            'error' => 'Order id not found'
        ]);
    }


    public function destroy(Product $order)
    {
        OrderQueue::where("product_id", $order->id)->where("user_id", auth()->user()->id)->delete();
        return back();
    }
}
