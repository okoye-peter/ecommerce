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
        <form class="row justify-content-center m-0 mt-3 align-content-center px-2" method="POST" action="{{ route('checkout', [$item['id']]) }}">
            <input type="hidden" name="name" value="{{$user->name}}">
            <input type="hidden" name="email" value="{{$user->email}}">
            <div class="col-2 product">  
                <img src="{{ asset($item['image']) }}" alt="">
            </div>

            <div class="col-3 py-3">
                {{ $item['name'] }}
            </div>
            <div class="col-2 py-3 {{ $item['name'] }}">
                <span>{{ $item['price'] }}</span>
                <input type="hidden" id="price" value="{{ $item['price'] }}" name="price">
            </div>
            <div class="col-2 py-3">
                <div class="form-group input-group-sm">
                    <span class="{{ $item['name'] }} mr-3">{{ $item['quantity'] }}</span>
                    <my-product-quantity-increase id="{{ $item['name'] }}" inc="{{ route('increase.quantity', $item['product_id']) }}"></my-product-quantity-increase>
                    <my-product-quantity-decrease id="{{ $item['name'] }}" dec="{{ route('decrease.quantity', $item['product_id']) }}"></my-product-quantity-decrease>
                </div>
            </div>
            <div class="col-3 py-3">
                <span>
                    <a href="{{ route('remove.from.cart', $item['product_id']) }}" class="mr-5">
                        <img src="{{ asset('css/remove-from-cart.svg') }}" style="height:20px; width:20px;color:red;">
                    </a>
                </span>
                <span>
                    <button type="submit" class="btn btn-raised btn-primary btn-sm">
                        checkout
                    </button>
                </span>
            </div>
            @csrf
        </form>    
    @endforeach
@endsection 