<div class="card">
    <div id="carousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($product->images as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset($image->path) }}" class="d-block w-100 card-image-top" height="500">
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <card class="card-body">
        <h4 class="right"><strong>${{ $product->price }}</strong></h4>
        <h5 class="card-title">{{ $product->title }}</h5>
        <p class="card-text">{{ $product->description }}</p>
        <p class="card-text">{{ $product->stock }} left</p>
        @if(isset($cart))
            <p class="card-text">
                {{ $product->pivot->quantity }} en tu carrito
                <strong>(${{ $product->total }})</strong>
            </p>
            <form
                action="{{ route('products.carts.destroy',['cart' => $cart->id, 'product' => $product->id]) }}"
                method="POST"
                class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">Eliminar del carrito</button>
            </form>
        @else
            <form
                action="{{ route('products.carts.store',['product' => $product->id]) }}"
                method="POST"
                class="d-inline">
                @csrf
                <button class="btn btn-success" type="submit">Agregar al carrito</button>
            </form>
        @endif
    </card>
</div>
