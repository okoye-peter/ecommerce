@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">    
@endsection

@section('content')
    <div class="row justify-content-center m-0 align-content-center px-2" id="heading">
        <div class="col-3 offset-2">
            Name
        </div>
        <div class="col-2">
            Price
        </div>
        <div class="col-2">
            Quantity
        </div>
        <div class="col-3">

        </div>
    </div>    
    @foreach ($orders as $item)        
    <div class="row justify-content-center m-0 mt-3 align-content-center px-2">
        <div class="col-2 col-lg-2 col-md-2 col-sm-2 product">  
            <img src="{{ asset($item['image']) }}" alt="">
        </div>

        <div class="col-3 col-lg-3 col-md-3 col-sm-3 py-3">
            {{ $item['name'] }}
        </div>
        <div class="col-2 col-lg-2 col-md-2 col-sm-2 py-3">
            <span class=" {{ $item['name'] }}">{{ $item['price'] }}</span>
        </div>
        <div class="col-2 col-lg-2 col-md-2 col-sm-2 py-3">
            <div class="form-group input-group-sm">
                <span class="{{ $item['name'] }} mr-3">{{ $item['quantity'] }}</span>
                <my-product-quantity-increase id="{{ $item['name'] }}" action="{{ route('increase.quantity', $item['product_id']) }}"></my-product-quantity-increase>
                <my-product-quantity-decrease id="{{ $item['name'] }}" action="{{ route('decrease.quantity', $item['product_id']) }}"></my-product-quantity-decrease>
            </div>
        </div>
        <div class="col-3 col-lg-3 col-md-3 col-sm-3 py-3">
            <span>
                <form action="{{ route('remove.from.cart', $item['product_id']) }}" class="mr-5 removeForm" method="POST" style="display: inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit"><i class="fa fa-trash" style="font-size: 20px"></i></button>
                    
                </form>
            </span>
            <span>
                <form style="display:inline" method="POST" action="{{ route('checkout', [$item['id']]) }}">
                    <input type="hidden" name="name" value="{{$user->name}}">
                    <input type="hidden" id="price" value="{{ $item['price'] }}" name="price" class="{{$item['name']}}">
                    <input type="hidden" name="email" value="{{$user->email}}">
                    <button type="submit" class="btn btn-raised btn-primary btn-sm">
                        checkout
                    </button>
                @csrf
            </form>    
            </span>
        </div>
    </div>
    @endforeach
@endsection 