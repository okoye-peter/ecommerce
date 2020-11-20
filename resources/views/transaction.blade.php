@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/transaction.css') }}">
@endsection
@section('content')
    <div class="wrapper">
        {{-- <div class="container-fluid">
            <div class="card card-info shadow-sm">
                <div class="card-head">
                    <h4>products name</h4>
                </div>
                <div class="card-body card-type-3">
                    <img src="{{asset('image/products/mouse_computer_green_82454_1280x720.jpg')}}" alt="">
                    <div>
                        <div class="pricing-details">
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fa fa-check"></i></div>
                                <div class="pricing-item-label">1 user agent</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fa fa-check"></i></div>
                                <div class="pricing-item-label">Core features</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fa fa-check"></i></div>
                                <div class="pricing-item-label">1GB storage</div>
                            </div>
                            <div class="pricing-item">
                                <div class="pricing-item-icon"><i class="fa fa-check"></i></div>
                                <div class="pricing-item-label">2 Custom domain</div>
                            </div>
                            <div class="pricing-item">
                                <span class="text-muted" style="font-size: 16px">price:</span> <strong class="text-info ml-2"><i>$9.99</i></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div>
                        <small class="text-muted">status:</small> <strong class="text-success ml-2">success</strong>
                    </div>
                    <div>
                        <small class="text-muted">date:</small> <strong class="text-danger ml-2">Jan 07, 2020.</strong>
                    </div>
                </div>    
            </div>
        </div> --}}
        <div class="grid_wrapper">
            @foreach ($transactions as $transaction)
                <div class="grid">
                    <div class="wrapper">
                        @php
                            $imgSrc = $transaction->product->image->first()->url;
                        @endphp
                        <img src='{{ asset("$imgSrc") }}' alt="">
                        <div class="content">
                            <p>Name: <span>{{ $transaction->product->name }}</span></p>
                            <p>Quantity: <span>{{ $transaction->quantity }}</span></p>
                            <p>Price: <span>${{ $transaction->price }}</span></p>
                            <p>Trans_ref: <span>{{ $transaction->gateway_ref }}</span></p>
                            <div class="footer">
                                <div>
                                    <small class="text-muted">status:</small> <strong>success</strong>
                                </div>
                                <div>
                                    <small class="text-muted">date:</small> <strong>{{date("y-M-d, H:i:s", strtotime($transaction->created_at))}}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection