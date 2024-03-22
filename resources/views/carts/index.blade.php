@extends('layouts.app')
@section('content')
    <div class="bg-dots-darker">
        <h1>Carrito</h1>
        @if(!isset($cart) OR $cart->products->isEmpty())
            <div class="alert alert-warning">
                No hay productos aún
            </div>
        @else
            <h4 class="text-center">
                <strong>
                    Total: ${{ $cart->total }}
                </strong>
            </h4>
            <a href="{{ route('orders.create') }}" class="btn btn-success mb-3">
                Ordenar
            </a>
            <div class="row">
                @foreach($cart->products as $product)
                    <div class="col-3">
                        @include('components.product-card')
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
