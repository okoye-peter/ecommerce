<?php

namespace App\Http\Controllers;

use App\Events\apiWebSocketsTestEvent;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        broadcast(new apiWebSocketsTestEvent('welcome'));
        $products = Product::where("quantity", '>' , 0)->inRandomOrder()->paginate(20);        
        return view('start', compact('products'));
    }
}
