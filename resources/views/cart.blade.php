@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">    
    <!--paystack -->
    <script src="https://js.paystack.co/v1/inline.js" defer></script>
    <!--flutterwave -->
    <script src="https://checkout.flutterwave.com/v3.js" defer></script>
@endsection

@section('content')
<h3 class="mb-0">Transaction</h3>
<hr>
<div class="cart">
    <div class="grids">
        @foreach ($orders as $order)
            <div class="card">
                <div class="card-body p-0">
                    <img src="{{ asset($order->product->image->first()->url) }}" alt="">
                    <div class="mb-1">
                        <p class="pl-2 mb-0">Name: {{$order->product->name}}</p>
                        <p class="pl-2 mb-0">Price: $<span class="price">{{$order->price}}</span></p>
                        <div class="d-flex">
                            {{-- <my-product-quantity-decrease id="{{$order->id}}" action="{{ route('decrease.quantity', $order->id) }}"></my-product-quantity-decrease> --}}
                            <product-quantity quantity_action="{{ route('set.product.quantity', [$order->id]) }}" :aquantity="{{ $order->quantity }}" decrease_action="{{ route('decrease.quantity', $order->id) }}" increase_action="{{ route('increase.quantity', $order->id) }}" :order="{{ $order }}"></product-quantity>
                            {{-- <my-product-quantity-increase id="{{$order->id}}" action="{{ route('increase.quantity', $order->id) }}"></my-product-quantity-increase> --}}
                        </div>
                        <div class="d-flex justify-content-end p-0 mr-2">
                            <form action="{{ route('remove.from.cart', $order->product_id) }}" class="removeForm" method="POST">
                                @csrf
                                <button type="submit"><i class="fa fa-trash-alt"></i></button>
                            </form>
                            <span>
                                <!-- paystack inline -->
                                {{-- <paystack-payment user="{{auth()->user()}}" product="{{$order}}" ></paystack-payment> --}}
                                <!-- flutterwave inline -->
                                <flutterwave-payment user="{{auth()->user()}}" product="{{$order}}" tx_ref="{{ Str::random(45) }}" ></flutterwave-payment>
                            </span>
                            {{-- <span>
                                <!-- paystack standard -->
                                <form style="display:inline" method="POST" action="{{ route('checkout', [$order->id]) }}">
                                        <button type="submit" class="btn btn-raised btn-primary btn-sm">
                                            checkout
                                        </button>
                                    @csrf
                                </form>    
                            </span> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection 

@section('script')
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection