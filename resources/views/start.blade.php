@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/start.css') }}">
@endsection

@section('content')
  <div class="row mx-auto">
    <div class="grid-wrapper" id="grid_wrapper">
      @foreach ($products as $product)
        <div class="grid wow fadeInUp">
          <div class="card mr-0 shadow">
            <div class="card-body">
              <a href="{{ route('display.product',$product->id) }}">
                <img src="{{ url($product->image->first()->url) }}" alt="" class="rounded">
              </a>
              <div class="mb-2">
                <p >
                  <strong class="text-muted">name: </strong> <i>{{ $product->name }}</i> <br>
                  <strong class="text-muted">price: </strong> <i>${{ $product->price }}</i>
                </p>
              </div>
              <div class="add_to_cart_form">
                <form action="{{ route('add.to.cart', [$product->id]) }}" method="get" onsubmit="
                  event.preventDefault();add_to_cart(this)"
                  >
                  @csrf
                  <button>Add <i class="fa fa-cart-plus"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    {{-- <div class="w-100 d-flex justify-content-center mt-5">
      {{ $products->links() }}
    </div> --}}
    <!-- add to cart alert -->
    <div id="alert" class="add_to_cart_alert">

    </div>
  </div>
  <div class="ajax-load text-center mt-3" style="display: none;">
    <p><img src="{{ asset('image/200.gif') }}" alt=""/> Loading more....</p>
  </div>
@endsection

@section('script')
  <script>
    function loadMoreData(page)
    {
      $.ajax({
        url: `?page=${page}`,
        type: 'get',
        beforeSend: function() {
          $(".ajax-load").show();
        }
      })
      .done(function(data){
        if (data.html == " ") {
          $(".ajax-load").html("No more records found");
          return;
        }
        $(".ajax-load").hide();
        $("#grid_wrapper").append(data.html);
        // console.log(data.html);
      })
      .fail(function(jqXHR, ajaxOptions, thrownError){
        console.log('jqXHR', jqXHR);
        console.log('ajaxOptions', ajaxOptions);
        console.log('thrownError', thrownError);
      })
    }

    var page = 1;
    $(window).scroll(function(){
      if($(window).scrollTop() + $(window).height() >= $(document).height()){
        page++;
        loadMoreData(page);
      }
    });
  </script> 
@endsection
