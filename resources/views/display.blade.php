@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/display.css') }}">

@endsection

@section('content')
  <div class="col-12 d-flex justify-content-center align-content-center w-100">
    <div class="shadow p-1 m-0" id="display">
      <div class="row m-0" id="first">
        <div class="col-8 p-1">
          <!-- Full-width images with number text -->
          <div class="mySlides .active">
            <div class="numbertext">1 / 6</div>
            <img class="rounded" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}">
          </div>

          <div class="mySlides">
            <div class="numbertext">2 / 6</div>
            <img class="rounded" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}">
          </div>

          <div class="mySlides">
            <div class="numbertext">3 / 6</div>
            <img class="rounded" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}">
          </div>

          <div class="mySlides">
            <div class="numbertext">4 / 6</div>
            <img class="rounded" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}">
          </div>

          <div class="mySlides">
            <div class="numbertext">5 / 6</div>
            <img class="rounded" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}">
          </div>

          <div class="mySlides">
            <div class="numbertext">6 / 6</div>
            <img src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}">
          </div>

          <!-- Next and previous buttons -->
          <a class="prev" onclick="nextSlide(-1)">&#10094;</a>
          <a class="next" onclick="nextSlide(1)">&#10095;</a>
        </div>
        <div class="col-4 p-1">
          <div>
            Node.js is a very powerful JavaScript-based platform built on Google Chrome's JavaScript V8 Engine. It is used
            to develop I/O intensive web applications like video streaming sites, single-page applications, and other web
            applications. Node.js is open source, completely free, and used by thousands of developers around the world.
            Node.js is a very powerful JavaScript-based platform built on Google Chrome's JavaScript V8 Engine. It is used
            to develop I/O intensive web applications like video streaming sites, single-page applications, and other web
            applications. Node.js is open source, completely free, and used by thousands of developers around the world.
            Node.js is a very powerful JavaScript-based platform built on Google Chrome's JavaScript V8 Engine. It is used
            to develop I/O intensive web applications like video streaming sites, single-page applications, and other web
            applications. Node.js is open source, completely free, and used by thousands of developers around the world.
          </div>
        </div>
      </div>
      <!-- Image text -->
      <div class="caption-container">
        <p id="caption" class="my-auto"></p>
      </div>
      <div class="row m-0 selection">
        <div class="container p-0">
          <!-- Thumbnail images -->
          <div class="row m-0">
            <div class="column">
              <img class="demo cursor" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}" style="width:100%"
                onclick="currentSlide(1)" alt="The Woods">
            </div>
            <div class="column">
              <img class="demo cursor" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}" style="width:100%"
                onclick="currentSlide(2)" alt="Cinque Terre">
            </div>
            <div class="column">
              <img class="demo cursor" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}" style="width:100%"
                onclick="currentSlide(3)" alt="Mountains and fjords">
            </div>
            <div class="column">
              <img class="demo cursor" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}" style="width:100%"
                onclick="currentSlide(4)" alt="Northern Lights">
            </div>
            <div class="column">
              <img class="demo cursor" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}" style="width:100%"
                onclick="currentSlide(5)" alt="Nature and sunrise">
            </div>
            <div class="column">
              <img class="demo cursor" src="{{ asset('storage/products/BjxZoS-B4Xs.jpg') }}" style="width:100%"
                onclick="currentSlide(6)" alt="Snowy Mountains">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/dispaly.js') }}"></script>
@endsection