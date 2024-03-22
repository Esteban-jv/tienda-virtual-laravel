@extends('layouts.app')

@section('content')
    <h1>Detalles de la orden</h1>
    <h4 class="text-center">
        <strong>
            Total: ${{ $cart->total }}
        </strong>
    </h4>

    <div class="text-center mb-3">
        <form
            action="{{ route('orders.store') }}"
            method="POST"
            class="d-inline">
            @csrf
            <button class="btn btn-success" type="submit">Confirmar orden</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-light">
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cart->products as $product)
                <tr>
                    <td>
                        <img src="{{ asset($product->images->first()->path) }}" width="100">
                        {{ $product->title }}
                    </td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>
                        <stong>
                            {{ $product->total }}
                        </stong>
                    </td>
                    <td>
                        <a href="{{
                                route('products.show',['product' => $product->id])
                            }}" class="btn btn-link">Show</a>
                        <a href="{{
                                route('products.edit',['product' => $product->id])
                            }}" class="btn btn-link">Editar</a>
                        <form method="POST" class="d-inline" action="{{ route('products.destroy',['product' => $product->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
