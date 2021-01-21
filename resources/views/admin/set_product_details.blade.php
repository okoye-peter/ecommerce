@extends('layouts.adminLayout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/set_product_details.css') }}">
@endsection
@section('content')
    <div class="container">
        <form action="{{ route('admin.product.store') }}" method="post" class="mt-4" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @foreach ($products as $key => $product)
                    <div class="col-3">
                        <img src='{{ asset("image/products/$product->images") }}' alt="product" class="product-img rounded shadow">
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="radio" name="front" value="{{ $product->images }}"> <span class="ml-3">front side</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4 mb-2">
                <div class="col-6">
                    <div class="form-group input_wrapper">
                        <label for="name">Product Name:</label>
                        <input type="text" class="form-control form-control-sm" name="name">
                        @error('name')
                            <span></span>
                            <small class="text-danger error">{{$message}}</small>
                        @enderror
                        
                    </div>
                    <div class="form-group input_wrapper">
                        <label for="name">Product Price:</label>
                        <input type="text" class="form-control form-control-sm" name="price">
                        @error('price')
                            <span></span>
                            <small class="text-danger error">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group input_wrapper">
                        <label for="name">Product Quantity:</label>
                        <input type="number" class="form-control form-control-sm" name="quantity">
                        @error('quantity')
                            <span></span>
                            <small class="text-danger error">{{$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group input_wrapper">
                        <label for="name">Product Category:</label>
                        <input type="text" class="form-control form-control-sm" name="category">
                        @error('category')
                            <span></span>
                            <small class="text-danger error">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group input_wrapper">
                        <label for="name">Product Sub-category:</label>
                        <input type="text" class="form-control form-control-sm" name="subcategory">
                        @error('subcategory')
                            <span></span>
                            <small class="text-danger error">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group input_wrapper">
                        <label for="name">Product Description:</label>
                        <textarea type="text" class="form-control" name="description"></textarea>
                        @error('description')
                            <span></span>
                            <small class="text-danger error">{{$message}}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <input type="submit" value="submit" class="btn btn-primary btn-sm d-block w-100">
        </form>
    </div>
@endsection