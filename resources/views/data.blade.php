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
                <add-to-cart-form action="{{ route('add.to.cart',$product->id)}}"></add-to-cart-form>
            </div>
        </div>
    </div>
@endforeach