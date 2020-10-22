@foreach ($products as $product)
    <div class="grid wow bounceInDown">
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
                    <form action="{{ route('add.to.cart', [$product->id]) }}" method="post" onsubmit="
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