<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PictureUpload;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */

     public $name = '';

    public function index()
    {
        $products = Product::where("quantity", '>', 0)->inRandomOrder()->paginate(20);
        return view('start', compact('products'));
    }

    static public function category()
    {
        $products = DB::table("products")
                        ->select('category','subcategory')
                        ->where('quantity', '>=', 1)
                        ->distinct('subcategory')
                        ->orderBy('category', "ASC")->get();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.productUpload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'front' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category' => 'required|string',
            'subcategory' => 'required|string',
            'description' => 'required|string'
        ]);
        $images = DB::table("product_images")->where('images', '!=', $data['front'])->where("user_id", '=', $request->user()->id)->get();
        $product = Product::create([
            'name' => $data['name'],
            'category' => $data['category'],
            'subcategory' => $data['subcategory'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'description' => $data['description'],
        ]);

        $product->image()->create(['url'=> json_encode(['front' => $data['front'], 'side' => $images->pluck('images')->toArray()])]);
        DB::table("product_images")->where("user_id", '=', $request->user()->id)->delete();
        return redirect('/admin');
        
    }

    public function saveImage(Request $request)
    {
        $imgs = Collection::wrap($request->file('images'));

        $imgs->each(function ($img){
            $name = PictureUpload::uploadImages($img);
            DB::insert('insert into product_images (user_id,images,created_at,updated_at) values(?,?,?,?)', [auth()->id(), $name, now(), now()]);
            $this->name = $name;
        });
        return $this->name;
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
        $products = Product::where('category', 'like', $category)
                            ->where('subcategory', 'like', $subcategory)
                            ->where("quantity", '>' , 0)
                            ->inRandomOrder()
                            ->paginate(18);

        if (request()->ajax()) {
            $view = view('data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('start', compact('products'));
    }

    public function search(Request $request){
        $products = Product::where('name', 'LIKE', "%".$request->input('key')."%")->paginate(18);
        if (request()->ajax()) {
            $view = view('data', compact('products'))->render();
            return response()->json(['html' => $view]);
        }
        return view('start', compact('products'));
    }

    public function delete(Request $request)
    {
        $public_id = Str::beforeLast(Str::afterLast($request->images, '/'), '.');
        if(DB::table("product_images")->where('images',$request->images)->where("user_id",'=',$request->user()->id)->delete()){
            // File::delete(public_path('/image/products/'.$record->images));
            PictureUpload::deleteImage($public_id);
            return response()->json(['success' => 'File deleted successfully']);
        }
    }

    public function setDescription()
    {
        $products = DB::table("product_images")->where("user_id", '=', auth()->id())->get();
        return view('admin.set_product_details', compact('products'));
    }
}
