<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use function foo\func;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */

    public function index()
    {
        // broadcast(new apiWebSocketsTestEvent('welcome'));
        $products = Product::where("quantity", '>', 0)->inRandomOrder()->paginate(20);
        return view('start', compact('products'));
    }

    static public function category()
    {
        $products = \DB::table("products")->select('category','subcategory')->where('quantity', '>=', 1)->distinct('subcategory')->orderBy('category', "ASC")->get();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('display', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function fetchSubcategoryProducts($category, $subcategory)
    {
        $products = Product::where('category', 'like', $category)->where('subcategory', 'like', $subcategory)->where("quantity", '>' , 0)->inRandomOrder()->paginate(20);

        return view('products', compact('products'));
    }

    public function search(Request $request){
        $products = Product::where('name', 'LIKE', "%".$request->input('key')."%")->get();
        return view('products', compact('products'));
    }
}
