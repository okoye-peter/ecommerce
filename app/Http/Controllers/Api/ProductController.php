<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imgs = Collection::wrap($request->file('file'));
        $imgs->each(function($img){
            $name = Str::random() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('/image/products'), $name);
            DB::insert('insert into product_images (user_id,images,created_at,updated_at) values(?,?,?,?)', [auth()->user()->id, $name, now(), now()]);
        });
    }
}
