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
    public function index(Request $request)
    {
        $products = Product::where("quantity", '>' , 0)->with('image')->inRandomOrder()->paginate(15);
        if ($request->ajax()) {
            $view = view('data',compact('products'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('start', compact('products'));
    }
}
