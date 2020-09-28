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
        @foreach ($orders as $item)
            <div class="card">
                <div class="card-body p-0">
                    <img src="{{ asset($item->product->image->first()->url) }}" alt="">
                    <div class="mb-2">
                        <p class="mb-0">Name: {{$item->product->name}}</p>
                        <p>Price: ${{$item->price}}</p>
                        <div class="d-flex">
                            <my-product-quantity-decrease id="{{$item->id}}" action="{{ route('decrease.quantity', $item->id) }}"></my-product-quantity-decrease>
                            <form action="" class="form-inline">
                                <input type="text" name="quantity" value="{{$item->quantity}}" onchange="if(this.vlaue == ''){console.log('changed')}">
                            </form>
                            <my-product-quantity-increase id="{{$item->id}}" action="{{ route('increase.quantity', $item->id) }}"></my-product-quantity-increase>
                        </div>
                        <div class="d-flex justify-content-end p-0">
                            <form action="{{ route('remove.from.cart', $item->product_id) }}" class="removeForm" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit"><i class="fa fa-trash-alt"></i></button>
                            </form>
                            <span>
                                <!-- paystack inline -->
                                {{-- <paystack-payment user="{{auth()->user()}}" product="{{$item}}" ></paystack-payment> --}}
                                <!-- flutterwave inline -->
                                <flutterwave-payment user="{{auth()->user()}}" product="{{$item}}" tx_ref="{{ Str::random(45) }}" ></flutterwave-payment>
                            </span>
                            {{-- <span>
                                <!-- paystack standard -->
                                <form style="display:inline" method="POST" action="{{ route('checkout', [$item->id]) }}">
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