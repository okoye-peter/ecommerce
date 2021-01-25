@extends('layouts.app')

@section('css')

<link rel="stylesheet" href="{{ asset('css/display.css') }}" defer>
@endsection

@section('content')
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-12">
        <div class="img_wrapper shadow rounded-sm">
          <div class="img_display">
            <i class="fa fa-angle-left fa-3x" onclick="nextSlide(-1)"></i>
              <img src="{{ asset('storage/products/IMG_20200405_121619_714.jpg') }}" alt="" class="rounded img_displayed">
            <i class="fa fa-angle-right fa-3x" onclick="nextSlide(1)"></i>
          </div>
          <div class="grid_block">
            <img src="{{ asset('storage/products/IMG_20200405_121619_714.jpg') }}" alt="" class="img-thumbnail rounded active" onclick="currentSlide(0)">
            <img src="{{ asset('storage/products/IMG_20200325_170620_923.jpg') }}" alt="" class="img-thumbnail rounded" onclick="currentSlide(1)">
            <img src="{{ asset('storage/products/IMG_20200115_101841_942.jpg') }}" alt="" class="img-thumbnail rounded" onclick="currentSlide(2)">
            <img src="{{ asset('storage/products/IMG_20200115_101858_378.jpg') }}" alt="" class="img-thumbnail rounded" onclick="currentSlide(3)">
          </div>
        </div>
      </div>

      <div class="col-md-4 col-sm-12 col-12 product-details">
        <div class="grids">
          <span>Name:</span>
          <span>Product Name</span>
        </div>
        <div class="grids">
          <span>Price:</span>
          <span>$2.99</span>
        </div>
        <div class="grids">
          <span>Description:</span>
          <span>
            Node.js is a very powerful JavaScript-based platform built on Google Chrome's JavaScript V8 Engine. It is used
            to develop I/O intensive web applications like video streaming sites, single-page applications, and other web
            applications. Node.js is open source, completely free, and used by thousands of developers around the world.
            Node.js is a very powerful JavaScript-based platform built on Google Chrome's JavaScript V8 Engine. It is used
            to develop I/O intensive web applications like video streaming sites, single-page applications, and other web
            applications. Node.js is open source, completely free, and used by thousands of developers around the world.
            
          </span>
        </div>
      </div>
    </div>


    <!-- The Modal -->
    <div id="myModal" class="modal">
      <span class="close dismiss-modal">&times;</span>
      <div class="modal-content">
        <i class="fa fa-angle-left fa-3x text-white"></i>
        <img class="modal-image" id="img01">
        <i class="fa fa-angle-right fa-3x text-white"></i>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ asset('js/dispaly.js') }}" defer></script>
@endsection