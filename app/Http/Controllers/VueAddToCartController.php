<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VueAddToCartController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validateProduct($product){
        return Validator::make($product, [
            'id' => 'exists:products,id'
        ]);
    }

    /**
     * @param Product
     * 
     * @return integer
     */
    public function addToCart(Product $product)
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
        }
        
    }

    /**
     * @param Product
     * 
     * @return array
     */
    public function increaseProductOrderQuantity(Product $product)
    {
        if ($product->id) {
            $orders = auth()->user()->orderQueue->where('product_id', $product->id)->first();
            $quantity = ++$orders->quantity;
            $price = $product->price * $quantity;
            $data = ["quantity" => $quantity, "price" => $price];
            $orders->update($data);
            return $data;
        }
    }

    /**
     * @param Product
     * 
     * @return array
     */
    public function decreaseProductOrderQuantity(Product $product)
    {

        if ($product->id) {
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
}
