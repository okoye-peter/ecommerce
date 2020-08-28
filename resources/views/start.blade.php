@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/start.css') }}">
@endsection

@section('content')
  <div class="row mx-auto">
    <div class="grid-wrapper">
      @foreach ($products as $product)
        <div class="grid wow bounceInDown">
          <div class="card mr-0 shadow">
            <div class="card-body">
              <a href="{{ route('display.product',$product->id) }}">
                <img src='{{ asset("$product->image") }}' alt="" class="rounded">
              </a>
              <div class="mb-2">
                <p >
                  <strong class="text-muted">name: </strong> <i>{{ $product->name }}</i> <br>
                  <strong class="text-muted">price: </strong> <i>${{ $product->price }}</i>
                </p>
              </div>
              <add-to-cart-form action="{{ route('add.to.cart',$product->id)}}"></add-to-cart-form>
            </div>
          </div>
        </div>
      @endforeach
      <div class="w-100 d-flex justify-content-center">
        {{ $products->links() }}
      </div>
    </div>
  </div>
@endsection
