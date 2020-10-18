@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/start.css') }}">
@endsection

@section('content')
  <div class="row mx-auto">
    <div class="grid-wrapper" id="grid_wrapper">
        @include('data')
      {{-- <div class="w-100 d-flex justify-content-center">
        {{ $products->links() }}
      </div> --}}
    </div>
    <!-- add to cart alert -->
    <div id="alert" class="add_to_cart_alert">

    </div>
  </div>
  <div class="ajax-load text-center mt-3">
    <p><img src="{{ asset('image/200.gif') }}" style="width:4em" alt=""/> Loading more....</p>
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
