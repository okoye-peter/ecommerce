@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">    
    <!--paystack -->
    <script src="https://js.paystack.co/v1/inline.js" defer></script>
    <!--flutterwave -->
    <script src="https://checkout.flutterwave.com/v3.js" defer></script>
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
            <img src="{{ asset($item->product->image->first()->url) }}" alt="">
        </div>

        <div class="col-3 col-lg-3 col-md-3 col-sm-3 py-3">
            {{ $item->product->name }}
        </div>
        <div class="col-2 col-lg-2 col-md-2 col-sm-2 py-3">
            <span class=" {{ $item->product->name }}">{{ $item->price }}</span>
        </div>
        <div class="col-2 col-lg-2 col-md-2 col-sm-2 py-3">
            <div class="form-group input-group-sm">
                <span class="{{ $item->product->name }} mr-3">{{ $item->quantity }}</span>
                <my-product-quantity-increase id="{{ $item->product->name }}" action="{{ route('increase.quantity', $item->product_id) }}"></my-product-quantity-increase>
                <my-product-quantity-decrease id="{{ $item->product->name }}" action="{{ route('decrease.quantity', $item->product_id) }}"></my-product-quantity-decrease>
            </div>
        </div>
        <div class="col-3 col-lg-3 col-md-3 col-sm-3 py-3">
            <span>
                {{-- <form action="{{ route('remove.from.cart', $item['product_id']) }}" class="mr-5 removeForm" method="POST" style="display: inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit"><i class="fa fa-trash" style="font-size: 20px"></i></button>
                    
                </form> --}}
                <!-- paystack inline -->
                <paystack-payment user="{{auth()->user()}}" product="{{$item}}" ></paystack-payment>
                <!-- flutterwave inline -->
                <flutterwave-payment user="{{auth()->user()}}" product="{{$item}}" tx_ref="{{ Str::random(45) }}" ></flutterwave-payment>
            </span>
            <span>
                <!-- paystack standard -->
                <form style="display:inline" method="POST" action="{{ route('checkout', [$item->id]) }}">
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