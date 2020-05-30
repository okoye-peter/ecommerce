<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use App\Product;
use Illuminate\Http\Request;

class VueAddToCartController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Product
     * 
     * @return integer
     */
    public function addToCart(Product $product)
    {
        $status = false;
        $a = auth()->user();

        foreach ($a->orderQueue as $key => $value) {
            if ($value->product_id == $product->id) {
                $status = true;
            }
        }

        if (!$status) {
            OrderQueue::create([
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'user_id' => auth()->user()->id,
                'product_id' => $product->id
            ]);
        }

        return count($a->orderQueue);
    }

    /**
     * @param Product
     * 
     * @return array
     */
    public function increaseProductOrderQuantity(Product $product)
    {
        $orders = auth()->user()->orderQueue->where('product_id', $product->id)->first();
        $quantity = ++$orders->quantity;
        $price = $product->price * $quantity;
        $data = ["quantity" => $quantity, "price" => $price];
        $orders->update($data);
        return $data;
    }

    /**
     * @param Product
     * 
     * @return array
     */
    public function decreaseProductOrderQuantity(Product $product)
    {
        $orders = auth()->user()->orderQueue->where('product_id', $product->id)->first();
        if ($orders->quantity > 1) {
            $quantity = --$orders->quantity;
            $price = $product->price * $quantity;
            $data = ["quantity" => $quantity, "price" => $price];
            $orders->update($data);
            return $data;
        }
        $data = ["quantity" => $orders->quantity, "price" => $orders->price];
        return $data;
    }
}
